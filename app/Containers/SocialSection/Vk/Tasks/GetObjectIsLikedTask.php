<?php

namespace App\Containers\SocialSection\Vk\Tasks;

final class GetObjectIsLikedTask
{
    public function run(string $access_token, $owner_id, $item_id, $type = 'post') : bool
    {
        $vk = new \VK\Client\VKApiClient();

        $response = $vk->likes()->isLiked($access_token, array(
            'owner_id' => $owner_id,
            'item_id' => $item_id,
            'type' => $type,
        ));

        return (bool) $response['liked'];
    }
}
