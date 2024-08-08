<?php

namespace App\Containers\Contest\Actions;

use App\Containers\Contest\Data\Types\Status;
use App\Containers\Contest\Tasks\GetReadyForStartContestsTask;

final class StartContestsAction
{
    public function run()
    {
        $contests = app(GetReadyForStartContestsTask::class)->run();
        foreach ($contests as $contest) {
            $contest->status = Status::Active;
            $contest->save();
        }
    }
}
