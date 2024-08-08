<?php

namespace App\Containers\SocialSection\Vk\Tasks;

final class GetUserIsMemberTask
{
    public function run(string $access_token, $group_id) : bool
    {
        $vk = new \VK\Client\VKApiClient();

        $response = $vk->groups()->isMember($access_token, array(
            'group_id' => $group_id,
            'extended' => 1,
        ));

        return (bool) $response['member'];
    }
}
