<?php

namespace App\Containers\SocialSection\Vk\Tasks;

final class GetAccessTokenTask
{
    public function run(string $code, string $redirect_uri) : string
    {
        $config = config('services.vkontakte');
        $client_id = $config['client_id'];
        $client_secret = $config['client_secret'];
        $redirect_uri = $redirect_uri;

        $oauth = new \VK\OAuth\VKOAuth();

        $response = $oauth->getAccessToken($client_id, $client_secret, $redirect_uri, $code);
        return $response['access_token'];
    }
}
