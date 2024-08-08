<?php

namespace App\Containers\Item\Tasks;

use App\Containers\Item\Models\Item;

final class GetItemUpperThanTask
{
    public function run(float $price, $direction = 'desc') : Item
    {
        return Item::where('price', '>=', $price)->orderBy('price', $direction)->first();
    }
}
