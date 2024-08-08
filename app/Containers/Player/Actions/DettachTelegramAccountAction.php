<?php

namespace App\Containers\Player\Actions;

use App\Containers\Player\Exceptions\API\ProfileException;
use App\Containers\Player\Tasks\GetAuthPlayerTask;

final class DettachTelegramAccountAction
{
    public function run()
    {
        $player = app(GetAuthPlayerTask::class)->run();

        if(!$player->telegramAccount()->exists()) throw new ProfileException('Аккаунт Telegram не привязан');

        $created_at = $player->telegramAccount()->value('created_at');
        $date = \Carbon\Carbon::now()->subDays(7);

        if($created_at > $date) {
            throw new ProfileException('Аккаунт Telegram можно отвязать через: ' . $created_at->diff($date)->format('%d дней %H часа(-ов) %I минут(-ы)'));
        }

        $player->telegramAccount()->delete();
    }
}
