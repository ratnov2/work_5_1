<?php

namespace App\Containers\SocialSection\Vk\Tasks;

final class GroupsSetCallbackSettingsTask
{
    public function run(string $access_token, array $params)
    {
        $vk = new \VK\Client\VKApiClient();
        return $vk->groups()->setCallbackSettings($access_token, $params);
    }
}
