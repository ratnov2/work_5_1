<?php

namespace App\Containers\Contest\Tasks;

use App\Containers\Contest\Models\Contest;
use Illuminate\Support\Collection;

final class GetFinishContestsTask
{
    public function run($limit = null) : Collection
    {
        $query = Contest::finish()->orderBy('end_at', 'desc');
        if(!is_null($limit)) $query = $query->limit($limit);
        return $query->get();
    }
}
