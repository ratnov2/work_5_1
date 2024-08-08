<?php

namespace App\Containers\Player\Actions;

use App\Containers\Player\Exceptions\API\ProfileException;
use App\Containers\Player\Models\Player;
use App\Containers\Player\Tasks\GetAuthPlayerTask;

final class TradeLinkAction
{
    public function run($trade_link)
    {
        $trade_link = trim($trade_link);

        $regexp = '!https://steamcommunity.com/tradeoffer/new/\?partner=([0-9]+)&([a-z0-9])!';
        if (!preg_match($regexp, $trade_link)) throw new ProfileException('Некорректная trade-ссылка');

        $player = app(GetAuthPlayerTask::class)->run();
        if (Player::where([['id', '!=', $player->id], ['trade_link', $trade_link]])->exists()) throw new ProfileException('Данная trade-ссылка уже используется. Вы можете сгенерировать новую trade-ссылку на сайте Steam');

        Player::where('id', $player->id)->update(['trade_link' => $trade_link]);

        return true;
    }
}
