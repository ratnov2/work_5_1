<?php

namespace App\Containers\TopContest\SubActions;

use App\Containers\Item\Tasks\GetItemLowerThanTask;
use App\Containers\Player\Tasks\GetPlayerByIdTask;
use App\Containers\Settings\Tasks\GetSettingsTopContestTask;
use Illuminate\Support\Facades\DB;

final class GetTopContestPlayersSubAction
{
    public function run(\Carbon\Carbon $date, $limit)
    {
        $top_contest_settings = app(GetSettingsTopContestTask::class)->run();

        $sum_jackpot_by_player_ids = DB::table('jackpot_bet_items')
            ->join('jackpot_bets', 'jackpot_bets.id', '=', 'jackpot_bet_items.jackpot_bet_id')
            ->groupBy('jackpot_bets.player_id')
            ->where('jackpot_bets.created_at', '>=', $date)
            ->selectRaw('sum(jackpot_bet_items.price) as sum, jackpot_bets.player_id as player_id')
            ->pluck('sum', 'player_id')
            ->toArray();

        $sum_upgrade_by_player_ids = DB::table('upgrades')
            ->join('item_player', 'item_player.id', '=', 'upgrades.item_player_id')
            ->groupBy('upgrades.player_id')
            ->where('upgrades.created_at', '>=', $date)
            ->selectRaw('sum(item_player.price) as sum, upgrades.player_id as player_id')
            ->pluck('sum', 'player_id')
            ->toArray();

        $sum_mines_by_player_ids = DB::table('mines_game_bets')
            ->join('item_player', 'item_player.id', '=', 'mines_game_bets.item_player_id')
            ->groupBy('item_player.player_id')
            ->where('mines_game_bets.created_at', '>=', $date)
            ->selectRaw('sum(item_player.price) as sum, item_player.player_id as player_id')
            ->pluck('sum', 'player_id')
            ->toArray();

        $sum_by_player_ids = [];
        $a1 = $sum_jackpot_by_player_ids;
        $a2 = $sum_upgrade_by_player_ids;
        $a3 = $sum_mines_by_player_ids;
        foreach (array_keys($a1 + $a2 + $a3) as $key)
            $sum_by_player_ids[$key] = (isset($a1[$key]) ? $a1[$key] : 0) + (isset($a2[$key]) ? $a2[$key] : 0) + (isset($a3[$key]) ? $a3[$key] : 0) + (isset($a4[$key]) ? $a4[$key] : 0);

        $sum_by_player_ids = collect($sum_by_player_ids)->sortDesc()->map(fn($sum, $player_id) => ['player_id' => $player_id, 'sum' => $sum])->values()->all();

        $top_contest_players = collect([]);
        for ($i = $limit; $i > 0; $i--) {
            $item = [
                'type' => 'default',
                'place' => $i,
                'sum' => null,
                'player' => null,
                'item' => null,
            ];

            if(isset($sum_by_player_ids[$i - 1])) {
                $item['sum'] = $sum_by_player_ids[$i - 1]['sum'];
                $item['player'] = app(GetPlayerByIdTask::class)->run($sum_by_player_ids[$i - 1]['player_id']);
            }

            if($i <= 3) $item['type'] = 'top';
            if($i == 1) $item['item'] = app(GetItemLowerThanTask::class)->run($top_contest_settings->first_place_sum);
            if($i == 2) $item['item'] = app(GetItemLowerThanTask::class)->run($top_contest_settings->second_place_sum);
            if($i == 3) $item['item'] = app(GetItemLowerThanTask::class)->run($top_contest_settings->third_place_sum);
            $top_contest_players->push($item);
        }

        $top_contest_players = $top_contest_players->sortBy('place');

        return $top_contest_players;
    }
}
