<?php

namespace App\Containers\Player\Tasks;

use App\Containers\Player\Models\Player;

final class UpdatePlayerVkAccountTask
{
    public function run(Player $player, array $params)
    {
        $player->vkAccount()->update($params);
    }
}
