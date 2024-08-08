<?php

namespace App\Containers\Player\Tasks;

use App\Containers\Player\Models\Player;

final class GetPlayerPaymentsSumTask
{
    public function run(Player $player, \Carbon\Carbon $start_date = null, \Carbon\Carbon $end_date = null)
    {
        $query = $player->payments()->success();
        if(!is_null($start_date)) $query = $query->whereDate('updated_at', '>=', $start_date);
        if(!is_null($end_date)) $query = $query->whereDate('updated_at', '<=', $end_date);
        return $query->sum('sum');
    }
}
