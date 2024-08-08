<?php

namespace App\Containers\TopContest\Tasks;

use App\Containers\TopContest\Models\TopContest;

final class GetLastTopContestTask
{
    public function run()
    {
        return TopContest::latest('id')->first();
    }
}
