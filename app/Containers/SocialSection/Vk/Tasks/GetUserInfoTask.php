<?php

namespace App\Containers\SocialSection\Vk\Tasks;

final class GetUserInfoTask
{
    public function run(string $access_token) : array
    {
        $vk = new \VK\Client\VKApiClient();

        $response = $vk->users()->get($access_token, array(
            'fields' => array('photo_200'),
        ));

        return $response[0];
    }
}
