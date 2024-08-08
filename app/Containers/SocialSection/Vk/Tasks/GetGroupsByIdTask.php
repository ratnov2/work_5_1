<?php

namespace App\Containers\SocialSection\Vk\Tasks;

final class GetGroupsByIdTask
{
    public function run(string $access_token, array $params = []) : array
    {
        $vk = new \VK\Client\VKApiClient();

        $params = array_merge(['extended' => 1], $params);

        return $vk->groups()->getById($access_token, $params);
    }
}
