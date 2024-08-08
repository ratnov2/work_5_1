<?php

namespace App\Containers\BoxLimit\Tasks;

use App\Containers\BoxLimit\Models\BoxLimit;

final class GetBoxLimitByIdTask
{
    public function run(int $id, $is_locked = false) : BoxLimit| null
    {
        $query = BoxLimit::where('id', $id);
        if($is_locked) $query = $query->lockForUpdate();
        return $query->first();
    }
}
