<?php

namespace App\Containers\Player\Tasks;

use App\Containers\Player\Data\Types\PlayerItemStatus;
use App\Containers\Player\Models\Player;
use Illuminate\Support\Facades\DB;

final class GetSumAllBetsTask
{
    public function run(Player $player, \Carbon\Carbon $start_date = null, \Carbon\Carbon $end_date = null)
    {
        $query = DB::table('item_player')->where('player_id', $player->id)->whereIn('status', [PlayerItemStatus::Upgrade, PlayerItemStatus::Jackpot]);
        if(!is_null($start_date)) $query = $query->whereDate('updated_at', '>=', $start_date);
        if(!is_null($end_date)) $query = $query->whereDate('updated_at', '<=', $end_date);
        return $query->sum('price');
    }
}
