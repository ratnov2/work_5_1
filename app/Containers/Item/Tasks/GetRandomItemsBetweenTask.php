<?php

namespace App\Containers\Item\Tasks;

use App\Containers\Item\Models\Item;
use Illuminate\Support\Collection;

final class GetRandomItemsBetweenTask
{
    public function run(float $min, float $max, int $limit = null) : Collection
    {
        $query = Item::inRandomOrder()->where('price', '>=', $min)->where('price', '<=', $max);
        if(!is_null($limit)) $query = $query->limit($limit);
        return $query->get();
    }
}
