<?php

namespace App\Containers\SocialSection\Telegram\Tasks;

final class GetAuthViewTask
{
    public function run(string $redirect_uri)
    {
        $telegram = config('services.telegram');

        $params = [
            'bot_name' => $telegram['bot_name'],
            'token' => $telegram['token'],
            'redirect_uri' => $redirect_uri,
        ];

        return view('socialsection.telegram::auth-button', ['params' => $params])->render();
    }
}
