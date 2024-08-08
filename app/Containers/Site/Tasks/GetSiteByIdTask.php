<?php

namespace App\Containers\Site\Tasks;

use App\Containers\Site\Models\Site;

final class GetSiteByIdTask
{
    public function run(int $id, $is_locked = false) : Site| null
    {
        $query = Site::where('id', $id);
        if($is_locked) $query = $query->lockForUpdate();
        return $query->first();
    }
}
