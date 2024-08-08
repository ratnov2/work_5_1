<?php

namespace App\Containers\Pages\Actions;

use App\Containers\Contest\Tasks\GetActiveContestsTask;
use App\Containers\Contest\Tasks\GetFinishContestsTask;
use App\Containers\Contest\UI\API\Resources\ContestResource;
use App\Containers\Contest\UI\API\Resources\HistoryContestResource;
use Illuminate\Support\Facades\View;

final class GetContestsViewAction
{
    public function run()
    {
        // Contests
        $contests_jsons = [];
        $contest_resources = ContestResource::collection(app(GetActiveContestsTask::class)->run());
        foreach ($contest_resources as $contest_resource)
            $contests_jsons[] = $contest_resource->toJson();

        // History contests
        $history_contests_jsons = [];
        $history_contest_resources = HistoryContestResource::collection(app(GetFinishContestsTask::class)->run(limit:3));
        foreach ($history_contest_resources as $history_contest_resource)
            $history_contests_jsons[] = $history_contest_resource->toJson();


        // Render
        $params = ['contests_jsons' => $contests_jsons, 'history_contests_jsons' => $history_contests_jsons];
        return View::make("pages::pages.contests.index")->with($params)->render();
    }
}
