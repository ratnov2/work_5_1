<?php

namespace App\Containers\Statistics\Actions;

use App\Containers\Player\Data\Types\PlayerItemStatus;
use App\Containers\Player\Models\Player;
use App\Containers\Trade\Models\Trade;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

final class GetStatisticsAction
{
    public function run() : array
    {
        return Cache::remember('site-statisitcs', 120, function() {
            $count_coins = round(DB::table('item_player')->whereStatus(PlayerItemStatus::Trade)->sum('price'), 2);
            $count_success_trades = Trade::success()->count();
            $count_players = Player::count();
    
            return [
                'status' => 'success',
                'count_players' => $count_players,
                'count_success_trades' => $count_success_trades,
                'count_coins' => $count_coins,
            ];
        });
    }
}
