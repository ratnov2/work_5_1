<?php

namespace App\Containers\Player\Tasks;

use App\Containers\Player\Data\Types\PlayerItemStatus;
use App\Containers\Player\Exceptions\API\ProfileException;
use App\Containers\Player\Models\Player;

final class CheckItemsPlayerForReadyTask
{
    public function run(Player $player, ...$player_items)
    {
        foreach ($player_items as $player_item) {
            if(!$player_item) throw new ProfileException('Предмет не найден');
            if($player_item->player_id != $player->id) throw new ProfileException('Предмет не найден');
            if($player_item->status != PlayerItemStatus::Ready->value) throw new ProfileException('Предмет, в данный момент, не в вашем инвентаре');
        }
        return true;
    }
}
