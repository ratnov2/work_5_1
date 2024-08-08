<?php

namespace App\Containers\Player\Tasks;

use App\Containers\Player\Models\Player;

final class UpdatePlayerTelegramAccountTask
{
    public function run(Player $player, array $params)
    {
        $player->telegramAccount()->update($params);
    }
}
