<?php

namespace App\Containers\SocialSection\Vk\Tasks;

final class GroupsGetCallbackConfirmationCodeTask
{
    public function run(string $access_token, array $params)
    {
        $vk = new \VK\Client\VKApiClient();

        return $vk->groups()->getCallbackConfirmationCode($access_token, $params);
    }
}
