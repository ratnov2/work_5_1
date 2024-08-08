<?php

namespace App\Containers\Player\Actions;

use App\Containers\Player\Exceptions\WEB\ProfileException;
use App\Containers\Player\Models\Player;
use App\Containers\Player\Tasks\GetAuthPlayerTask;
use App\Containers\Player\Tasks\AttachPlayerTelegramAccountTask;
use App\Containers\SocialSection\Telegram\Tasks\CheckTelegramAuthorizationTask;

final class AttachTelegramAccountAction
{
    public function run($user_info)
    {
        $player = app(GetAuthPlayerTask::class)->run();

        if($player->telegramAccount()->exists()) throw new ProfileException('Аккаунт Telegram уже привязан');

        $user_info = app(CheckTelegramAuthorizationTask::class)->run($user_info);

        if(Player::where('id', '<>', $player->id)->whereHas('telegramAccount', function($telegram_account) use($user_info) {
            $telegram_account->where('telegram_id', $user_info['id']);
        })->exists()) {
            throw new ProfileException('Этот аккаунт Telegram уже используется другим игроком');
        }

        $params = [
            'name' => ($user_info['first_name'] ?? '') . " " . ($user_info['last_name'] ?? ''),
            'username' => $user_info['username'] ?? null,
            'telegram_id' => $user_info['id'],
        ];

        app(AttachPlayerTelegramAccountTask::class)->run($player, $params);
    }
}
