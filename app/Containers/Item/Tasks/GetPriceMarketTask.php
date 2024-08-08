<?php

namespace App\Containers\Item\Tasks;

use App\Containers\Item\Models\Item;

final class GetPriceMarketTask
{
    public function run(string $market_hash_name)
    {
        return Item::where('market_hash_name', $market_hash_name)->value('price_market');
    }
}
