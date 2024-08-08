<?php

namespace App\Containers\Mines\Actions;

use App\Containers\Mines\Data\Types\Status;
use App\Containers\Mines\Tasks\GenerateMinesCellIndexesTask;
use App\Containers\Mines\Tasks\GetCoefficientsByCountMinesTask;
use App\Containers\Mines\UI\API\Exceptions\MinesException;
use App\Containers\Player\Tasks\GetAuthPlayerTask;
use Illuminate\Support\Facades\DB;

final class TakePrizeAction
{
    public function run()
    {
        return DB::transaction(function () {
            $player = app(GetAuthPlayerTask::class)->run(is_locked:true);

            $mines_game = $player->minesGames()->inGame()->first();

            if(!$mines_game) throw new MinesException('Вы еще не начали игру');

            $coefficients = app(GetCoefficientsByCountMinesTask::class)->run($mines_game->count_mines);
            $cell_results = $mines_game->cell_results;
            $step = count($cell_results) - 1;

            $bet_amount = $mines_game->bets->map(fn($bet) => $bet->playerItem)->sum('price');
            $win_amount = $bet_amount * $coefficients[$step];

            foreach (app(GenerateMinesCellIndexesTask::class)->run($cell_results, $mines_game->count_mines) as $mine_cell_index)
                $cell_results[$mine_cell_index] = false;

            $mines_game->fill(['cell_results' => $cell_results, 'win_amount' => $win_amount, 'balance' => $win_amount, 'status' => Status::END]);
            $mines_game->save();

            $player->balance += $win_amount;
            $player->save();

            return ['mines_game' => $mines_game, 'player_balance' => $player->balance];
        });
    }
}
