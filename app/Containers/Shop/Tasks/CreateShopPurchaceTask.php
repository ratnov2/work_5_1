<?php

namespace App\Containers\Shop\Tasks;

use App\Containers\Player\Models\Player;
use App\Containers\Shop\Models\ShopPurchace;

final class CreateShopPurchaceTask
{
    public function run(Player $player, $market_hash_names, float $price) : ShopPurchace
    {
        return ShopPurchace::create([
            'player_id' => $player->id,
            'market_hash_names' => json_encode($market_hash_names),
            'price' => $price
        ]);
    }
}
