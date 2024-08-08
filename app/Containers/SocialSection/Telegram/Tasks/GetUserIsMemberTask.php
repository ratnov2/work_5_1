<?php

namespace App\Containers\SocialSection\Telegram\Tasks;

use Illuminate\Support\Facades\Http;

final class GetUserIsMemberTask
{
    public function run($user_id, $chat_id) : bool
    {
        $token = config('services.telegram.token');

        $params = [
            'user_id' => $user_id,
            'chat_id' => $chat_id,
        ];

        $response = Http::acceptJson()->post('https://api.telegram.org/bot' . $token . '/getChatMember', $params);

        $data = $response->json();

        if($data['ok'] == false) return false;

        if($data['result']['status'] == 'left') return false;

        return true;
    }
}
