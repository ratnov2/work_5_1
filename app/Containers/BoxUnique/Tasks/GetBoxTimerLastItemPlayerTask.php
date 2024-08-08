<?php

namespace App\Containers\BoxUnique\Tasks;

use App\Containers\BoxUnique\Models\Box;

final class GetBoxTimerLastItemPlayerTask
{
    public function run($player)
    {
        $box = app(GetTimerableBoxTask::class)->run();

        return $player->items()
            ->where('dropable_type', Box::class)
            ->where('dropable_id', $box->id)
            ->orderBy('created_at', 'desc')
            ->first();
    }
}
