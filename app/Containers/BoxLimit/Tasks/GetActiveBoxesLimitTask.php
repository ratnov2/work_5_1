<?php

namespace App\Containers\BoxLimit\Tasks;

use App\Containers\BoxLimit\Models\BoxLimit;

final class GetActiveBoxesLimitTask
{
    public function run($is_locked = false)
    {
        return BoxLimit::active()->get();
    }
}
