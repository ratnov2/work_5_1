<?php

namespace App\Containers\SocialSection\Vk\Tasks;

final class GetGroupsTask
{
    public function run(string $access_token, array $params = []) : array
    {
        $vk = new \VK\Client\VKApiClient();

        $params = array_merge(['extended' => 1], $params);

        $response = $vk->groups()->get($access_token, $params);

        return $response['items'];
    }
}
