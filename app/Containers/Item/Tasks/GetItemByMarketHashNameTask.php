<?php

namespace App\Containers\Item\Tasks;

use App\Containers\Item\Models\Item;

final class GetItemByMarketHashNameTask
{
    public function run(string $market_hash_name) : Item|null
    {
        return Item::where('market_hash_name', $market_hash_name)->first();
    }
}
