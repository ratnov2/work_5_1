<?php

namespace App\Containers\Player\Tasks;

use App\Containers\Player\Events\PlayerAttachTelegramAccountEvent;
use App\Containers\Player\Models\Player;

final class AttachPlayerTelegramAccountTask
{
    public function run(Player $player, array $params)
    {
        $account = $player->telegramAccount()->create($params);

        event(new PlayerAttachTelegramAccountEvent($account));

        return $account;
    }
}
