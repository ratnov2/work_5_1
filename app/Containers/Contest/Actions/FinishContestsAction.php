<?php

namespace App\Containers\Contest\Actions;

use App\Containers\Contest\Data\Types\Status;
use App\Containers\Contest\Notifications\PlayerWinContest;
use App\Containers\Contest\Tasks\GetReadyForFinishContestsTask;
use App\Containers\Item\Tasks\GetItemByMarketHashNameTask;
use App\Containers\Player\SubActions\AddDropablePlayerItemsSubAction;
use Illuminate\Support\Facades\DB;

final class FinishContestsAction
{
    public function run()
    {
        $contests = app(GetReadyForFinishContestsTask::class)->run();

        DB::transaction(function() use($contests) {
            foreach ($contests as $contest) {
                if($contest->players->count() != 0) {
                    $win_player = $contest->players()->inRandomOrder()->first();
                    $win_item = app(GetItemByMarketHashNameTask::class)->run($contest->market_hash_name);

                    app(AddDropablePlayerItemsSubAction::class)->run($win_player, $contest, $win_item);

                    $win_player->notify(new PlayerWinContest($contest));
                    $contest->win_player_id = $win_player->id;
                }
                $contest->status = Status::Finish;
                $contest->save();
            }
        });
    }
}
