<?php

namespace App\Containers\Mines\Tasks;

use App\Containers\Mines\Data\Types\Status;

final class UpdateWinMinesGameTask
{
    public function run($mines_game, $win_amount)
    {
        $mines_game->fill(['win_amount' => $win_amount, 'status' => Status::END]);

        return $mines_game;
    }
}
