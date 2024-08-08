<?php

namespace App\Containers\Item\Tasks;

use App\Containers\Item\Models\Item;

final class GetItemLikeMarketHashNameTask
{
    public function run(string $market_hash_name) : Item|null
    {
        return Item::where('market_hash_name', 'LIKE', "%$market_hash_name%")->orWhere('ru_market_hash_name', 'LIKE', "%$market_hash_name%")->first();
    }
}
