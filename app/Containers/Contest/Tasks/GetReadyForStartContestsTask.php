<?php

namespace App\Containers\Contest\Tasks;

use App\Containers\Contest\Models\Contest;
use Illuminate\Support\Collection;

final class GetReadyForStartContestsTask
{
    public function run($is_locked = false) : Collection
    {
        $query = Contest::wait()->where('reserved_at', '<', \Carbon\Carbon::now());
        if($is_locked) $query = $query->lockForUpdate();
        return $query->get();
    }
}
