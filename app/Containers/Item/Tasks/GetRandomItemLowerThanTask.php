<?php

namespace App\Containers\Item\Tasks;

use App\Containers\Item\Models\Item;

final class GetRandomItemLowerThanTask
{
    public function run(float $price) : Item|null
    {
        return Item::inRandomOrder()->where('price', '<=', $price)->first();
    }
}
