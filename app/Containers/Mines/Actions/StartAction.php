<?php

namespace App\Containers\Mines\Actions;

use App\Containers\GameModes\Tasks\GetBankMinesTask;
use App\Containers\Mines\Data\Types\Status;
use App\Containers\Mines\UI\API\Exceptions\MinesException;
use App\Containers\Mines\Models\MinesGame;
use App\Containers\Mines\Models\MinesGameBet;
use App\Containers\Player\Data\Types\PlayerItemStatus;
use App\Containers\Player\Tasks\CheckItemsPlayerForReadyTask;
use App\Containers\Player\Tasks\GetAuthPlayerTask;
use App\Containers\Player\Tasks\GetItemsPlayerByUniqidsTask;
use App\Containers\Player\Tasks\UpdateItemsPlayerByUniqidsTask;
use Illuminate\Support\Facades\DB;

final class StartAction
{
    public function run(array $uniqids, int $count_mines)
    {
        if($count_mines < 2 || $count_mines > 24) throw new MinesException('Кол-во мин должно быть от 2 до 24');
        
        return DB::transaction(function () use($uniqids, $count_mines) {
            $player = app(GetAuthPlayerTask::class)->run(is_locked:true);
            $bank = app(GetBankMinesTask::class)->run(is_locked:true);

            if($mines_game = $player->minesGames()->inGame()->exists()) throw new MinesException('У вас уже есть начатая игра');

            $player_items = app(GetItemsPlayerByUniqidsTask::class)->run(true, ...$uniqids);
            app(CheckItemsPlayerForReadyTask::class)->run($player, ...$player_items);
            app(UpdateItemsPlayerByUniqidsTask::class)->run(
                ['status' => PlayerItemStatus::Mines],
                ...$player_items->map(fn($player_item) => $player_item->uniqid),
            );

            $mines_game = MinesGame::create(['player_id' => $player->id, 'count_mines' => $count_mines, 'status' => Status::IN_GAME, 'cell_results' => null]);
            foreach ($player_items as $player_item)
                MinesGameBet::create(['mines_game_id' => $mines_game->id, 'item_player_id' => $player_item->id]);

            $bank->value += $player_items->sum('price') * (100 - 10) / 100;
            $bank->save();

            return ['mines_game' => $mines_game];
        });
    }
}
