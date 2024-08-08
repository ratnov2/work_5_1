<?php

namespace App\Containers\Contest\Tasks;

use App\Containers\Contest\Models\Contest;
use Illuminate\Support\Collection;

final class GetActiveContestsTask
{
    public function run($limit = null) : Collection
    {
        $query = Contest::active()->orderBy('position');
        if($limit != null) $query = $query->limit($limit);
        return $query->get();
    }
}
