<?php

namespace App\Containers\Player\SubActions;

use App\Containers\Player\Data\Types\PlayerItemStatus;
use App\Containers\Player\Models\Player;
use App\Containers\Player\Models\PlayerItem;
use Illuminate\Support\Str;

final class AddDropablePlayerItemsSubAction
{
    public function run(Player $player, $dropable_instance, ...$items)
    {
        foreach ($items as $item) {
            $player_items[] = PlayerItem::create([
                'player_id' => $player->id,
                'market_hash_name' => $item->market_hash_name,
                'price' => $item->price,
                'uniqid' => Str::random(36),
                'dropable_type' => get_class($dropable_instance),
                'dropable_id' => $dropable_instance->id,
                'status' => PlayerItemStatus::Ready
            ]);
        }

        return $player_items;
    }
}
