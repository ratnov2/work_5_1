<?php

namespace App\Containers\Pages\Actions;

use App\Containers\Settings\Tasks\GetSettingsTopContestTask;
use App\Containers\TopContest\SubActions\GetTopContestPlayersSubAction;
use App\Containers\TopContest\Tasks\GetLastTopContestTask;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;

final class GetGameModesTopContestViewAction
{
    public function run()
    {
        return Cache::remember('top_contest_view', 60, function() {
            $top_contest_settings = app(GetSettingsTopContestTask::class)->run();
            $last_top_contest = app(GetLastTopContestTask::class)->run();
            $top_contest_players = app(GetTopContestPlayersSubAction::class)->run(date:$last_top_contest->created_at, limit:10);

            $params = [
                'top_contest_settings' => $top_contest_settings,
                'next_start_date' => $last_top_contest->created_at->addHours($top_contest_settings->every_hours)->timestamp * 1000,
                'top_contest_players' => $top_contest_players
            ];

            return View::make("pages::pages.gameModes.pages.topContest.index")->with($params)->render();
        });
    }
}
