<?php

namespace App\Containers\Jackpot\Tasks;

use App\Containers\Jackpot\Data\Types\Status;
use App\Containers\Jackpot\Events\StartJackpotEvent;
use App\Containers\Jackpot\Models\Jackpot;

final class CheckStartActivateJackpotTask
{
    public function run(Jackpot $jackpot)
    {
        if($jackpot->bets()->pluck('player_id')->unique()->count() > 1) {
            $jackpot->status = Status::WaitTimeout;
            $jackpot->save();
            event(new StartJackpotEvent());
        }
    }
}
