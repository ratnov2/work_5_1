<?php

namespace App\Containers\Condition\SubActions;

use App\Containers\Condition\Exceptions\ConditionException;
use App\Containers\Player\Models\Player;
use App\Containers\SocialSection\Telegram\Tasks\GetUserIsMemberTask;

final class ValidateTelegramPlatformSubAction
{
    public function run(Player $player, array $platform)
    {
        try {
            if(!$player->telegramAccount) throw new ConditionException('Необходимо привязать свой Telegram аккаунт в вашем профиле');

            // Subscribes
            if(isset($platform['subscribes'])) {
                foreach ($platform['subscribes'] as $subscribe) {
                    $arr = explode('/', $subscribe['link']);

                    $chat_id = '@' . end($arr);

                    $result = app(GetUserIsMemberTask::class)->run($player->telegramAccount->telegram_id, $chat_id);

                    if(!$result) throw new ConditionException('Вы не выполнили условие: подписаться на канал');
                }
            }
        } catch (\Throwable $th) {
            if($th instanceof ConditionException) throw $th;
            throw new ConditionException('Ошибка сервиса Telegram. Пожалуйста, попробуйте перепривязать ваш аккаунт Telegram в профиле или попробуйте позже...');
        }
    }
}
