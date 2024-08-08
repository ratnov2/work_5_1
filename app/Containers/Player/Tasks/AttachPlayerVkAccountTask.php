<?php

namespace App\Containers\Player\Tasks;

use App\Containers\Player\Events\PlayerAttachVkAccountEvent;
use App\Containers\Player\Models\Player;

final class AttachPlayerVkAccountTask
{
    public function run(Player $player, array $params)
    {
        $account = $player->vkAccount()->create($params);

        event(new PlayerAttachVkAccountEvent($account));

        return $account;
    }
}
