<?php

namespace App\Containers\SocialSection\Vk\Tasks;

final class GroupsAddCallbackServerTask
{
    public function run(string $access_token, array $params)
    {
        $vk = new \VK\Client\VKApiClient();
        return $vk->groups()->addCallbackServer($access_token, $params)['server_id'];
    }
}
