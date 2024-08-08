<?php

namespace App\Containers\BoxUnique\Tasks;

use App\Containers\BoxUnique\Models\Box;

final class GetTimerableBoxTask
{
    public function run() : Box
    {
        return Box::timerable()->first();
    }
}
