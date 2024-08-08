<?php

namespace App\Containers\TopContest\Actions;

use App\Containers\Player\Events\SendStorePlayerEvent;
use App\Containers\Player\SubActions\AddDropablePlayerItemsSubAction;
use App\Containers\Player\UI\API\Resources\PlayerItemResource;
use App\Containers\Settings\Tasks\GetSettingsTopContestTask;
use App\Containers\TopContest\Models\TopContest;
use App\Containers\TopContest\SubActions\GetTopContestPlayersSubAction;
use App\Containers\TopContest\Tasks\GetLastTopContestTask;
use Illuminate\Support\Facades\DB;

final class FinishTopContestsAction
{
    public function run()
    {
        $top_contest_settings = app(GetSettingsTopContestTask::class)->run();

        $date = \Carbon\Carbon::now()->subHours($top_contest_settings->every_hours);

        $last_top_contest = app(GetLastTopContestTask::class)->run();

        if($last_top_contest->created_at >= $date) return false;

        $top_players = app(GetTopContestPlayersSubAction::class)
            ->run($last_top_contest->created_at, 3)
            ->filter(function($top_player) {
                return !is_null($top_player['player']) && !is_null($top_player['item']);
            });

        $events = DB::transaction(function() use($top_players) {
            $top_contest = TopContest::create([]);

            $events = [];
            foreach ($top_players as $top_player) {
                $player_item = app(AddDropablePlayerItemsSubAction::class)->run($top_player['player'], $top_contest, $top_player['item'])[0];

                $events[] = new SendStorePlayerEvent($top_player['player']->id, add_player_items:[new PlayerItemResource($player_item)], msg:'Вам выдан скин за ' . $top_player['place'] . ' место в  ежедневном топе. Так держать!');
            }

            return $events;
        });

        foreach ($events as $event) event($event);
    }
}
