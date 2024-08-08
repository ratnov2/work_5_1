<?php

namespace App\Containers\Contest\Tasks;

use App\Containers\Contest\Models\Contest;

final class GetContestByIdTask
{
    public function run(int $id) : Contest|null
    {
        return Contest::where('id', $id)->first();
    }
}
