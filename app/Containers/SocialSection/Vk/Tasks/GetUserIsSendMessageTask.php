<?php

namespace App\Containers\SocialSection\Vk\Tasks;

final class GetUserIsSendMessageTask
{
    public function run(string $access_token, string $q, $peer_id) : bool
    {
        $vk = new \VK\Client\VKApiClient();

        $response = $vk->messages()->search($access_token, array(
            'q' => $q,
            'peer_id' => $peer_id,
            'count' => 10,
            'extended' => 0,
        ));

        foreach ($response['items'] as $message) {
            if($message['from_id'] == $peer_id && $message['text'] == $q) return true;
        }

        return false;
    }
}
