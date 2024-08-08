<?php

namespace App\Containers\Jackpot\Tasks;

use App\Containers\Jackpot\Models\Jackpot;

final class GetJackpotBankTask
{
    public function run(Jackpot $jackpot)
    {
        $sum = 0;
        $jackpot->bets->each(function($bet) use($sum) {
            $sum += $bet->items->sum('price');
        });
        return $sum;
    }
}
