<?php

namespace App\Containers\Item\Tasks;

use App\Containers\Item\Models\Item;

final class GetRandomItemBetweenTask
{
    public function run(float $min, float $max) : Item|null
    {
        $query = Item::inRandomOrder()->where('price', '>=', $min)->where('price', '<=', $max);
        return $query->first();
    }
}
