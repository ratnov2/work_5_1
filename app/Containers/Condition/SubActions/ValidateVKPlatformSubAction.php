<?php

namespace App\Containers\Condition\SubActions;

use App\Containers\AdSection\VkGroup\Tasks\GetGroupByVkShortNameTask;
use App\Containers\Condition\Exceptions\ConditionException;
use App\Containers\Player\Models\Player;
use App\Containers\SocialSection\Vk\Tasks\GetObjectIsLikedTask;
use App\Containers\SocialSection\Vk\Tasks\GetUserIsMemberTask;
use App\Containers\SocialSection\Vk\Tasks\GetUserIsSendMessageTask;
use App\Containers\SocialSection\Vk\Tasks\GetWallIsRepostedTask;

final class ValidateVKPlatformSubAction
{
    public function run(Player $player, array $platform)
    {
        try {
            if(!$player->vkAccount) throw new ConditionException('Необходимо привязать свой VK аккаунт в вашем профиле');

            // Likes
            if(isset($platform['likes'])) {
                foreach ($platform['likes'] as $like) {
                    $start_pos = strpos($like['link'], "-");
                    $owner_id_and_item_id = explode('_', substr($like['link'], $start_pos));

                    $result = app(GetObjectIsLikedTask::class)->run($player->vkAccount->access_token, $owner_id_and_item_id[0], $owner_id_and_item_id[1]);
                    if(!$result) throw new ConditionException('Вы не выполнили условие: поставить лайк');
                }
            }

            // Subscribes
            if(isset($platform['subscribes'])) {
                foreach ($platform['subscribes'] as $subscribe) {
                    $arr = explode('/', $subscribe['link']);
                    $group_id = end($arr);

                    if(str_starts_with($group_id, 'public')) {
                        $group_id = substr($group_id, 6);
                    } elseif(str_starts_with($group_id, 'club')) {
                        $group_id = substr($group_id, 4);
                    }

                    $result = app(GetUserIsMemberTask::class)->run($player->vkAccount->access_token, $group_id);
                    if(!$result) throw new ConditionException('Вы не выполнили условие: подписаться на группу');
                }
            }

            // Reposts
            if(isset($platform['reposts'])) {
                foreach ($platform['reposts'] as $repost) {
                    $start_pos = strpos($repost['link'], "wall-");
                    $owner_id_and_item_id = explode('_', substr($repost['link'], $start_pos + 4));

                    $result = app(GetWallIsRepostedTask::class)->run($player->vkAccount->access_token, $owner_id_and_item_id[0], $owner_id_and_item_id[1]);
                    if(!$result) throw new ConditionException('Вы не выполнили условие: сделать репост записи');
                }
            }

            // Messages
            if(isset($platform['messages'])) {
                foreach ($platform['messages'] as $message) {
                    $group = app(GetGroupByVkShortNameTask::class)->run($message['vk_short_name']);
                    $result = app(GetUserIsSendMessageTask::class)->run($group->access_token, $message['text'], $player->vkAccount->vk_id);
                    if(!$result) throw new ConditionException('Вы не выполнили условие: написать в лс');
                }
            }

        } catch (\Throwable $th) {
            if($th instanceof ConditionException) throw $th;
            if($th instanceof \VK\Exceptions\Api\VKApiAuthException) throw new ConditionException('Мы не смогли отправить запрос на проверку условий VK. Пожалуйста, попробуйте перепривязать ваш аккаунт VK в профиле.');
            if($th instanceof \VK\Exceptions\Api\VKApiTooManyException) throw new ConditionException('Слишком много запросов к VK. Попробуйте через несколько секунд');
            throw new ConditionException('Ошибка сервиса VK. Пожалуйста, попробуйте перепривязать ваш аккаунт VK в профиле или попробуйте позже...');
        }
    }
}
