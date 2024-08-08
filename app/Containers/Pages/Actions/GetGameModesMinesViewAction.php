<?php

namespace App\Containers\Pages\Actions;

use App\Containers\Mines\UI\API\Resources\PlayerMineGameResource;
use App\Containers\Player\Tasks\GetAuthPlayerTask;
use Illuminate\Support\Facades\View;

final class GetGameModesMinesViewAction
{
    public function run()
    {
        $player = app(GetAuthPlayerTask::class)->run();

        if($player) {
            $mines_game = $player->minesGames()->inGame()->first();
            $mines_game = $mines_game ? (new PlayerMineGameResource($mines_game))->toJson() : null;
        }

        return View::make("pages::pages.gameModes.pages.mines.index")->with([
            'player' => $player,
            'mines_game' => $mines_game ?? null,
        ])->render();
    }
}
