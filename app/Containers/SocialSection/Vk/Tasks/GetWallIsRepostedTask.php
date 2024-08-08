<?php

namespace App\Containers\SocialSection\Vk\Tasks;

final class GetWallIsRepostedTask
{
    public function run(string $access_token, $owner_id, $item_id)
    {
        $vk = new \VK\Client\VKApiClient();

        $response = $vk->wall()->get($access_token, array(
            'filter' => 'owner',
        ));

        foreach ($response['items'] as $wall) {
            if(!isset($wall['copy_history'])) continue;

            foreach ($wall['copy_history'] as $history) {
                if($history['id'] == $item_id && $history['owner_id'] == $owner_id) return true;
            }
        }

        return false;
    }
}
