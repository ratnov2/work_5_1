<?php

namespace App\Containers\SocialSection\Telegram\UI\API\Controllers;

use App\Containers\Player\Tasks\GetPlayerBySteamIdTask;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WebhookController extends Controller
{
    public function handle(Request $request)
    {
        try {
            if (!$request->isJson()) return false;

            $json = $request->json();

            if (
                !$json->has('update_id') ||
                !$json->has('message')
            ) return false;

            $message = $json->get('message');

            if (!$message['chat']) return false;
            if (!str_starts_with($message['text'], '/attach')) return false;
            if (filter_var($message['from']['is_bot'], FILTER_VALIDATE_BOOLEAN) == true) return false;

            $steam_id = str_replace('/attach', '', $message['text']);
            $player = app(GetPlayerBySteamIdTask::class)->run($steam_id);

            if (!$player) return false;

            $params = [
                'telegram_id' => $message['from']['id'],
                'name' => isset($message['from']['last_name']) ? $message['from']['first_name'] . ' ' . $message['from']['last_name'] : $message['from']['first_name'],
                'username' => isset($message['from']['username']) ? $message['from']['username'] : null,
            ];

            if ($player->telegramAccount) {
                $player->telegramAccount()->update($params);
                $msg = 'Вы успешно перепривязали свой аккаунт, обновите страницу на сайте!';
            } else {
                $player->telegramAccount()->create($params);
                $msg = 'Ваш аккаунт успешно привязан, обновите страницу на сайте!';
            }

            $telegram_config = config('services.telegram');
            Http::post("https://api.telegram.org/bot" . $telegram_config['token'] . "/sendMessage", [
                'chat_id' => $message['chat']['id'],
                'text' => $msg,
            ]);

            return 'Success';

        } catch (\Throwable $th) {
            Log::error('telegram_webhook_error ' . $th->getMessage() . $th->getFile());
            return 'Attach player telegram error';
        }
    }
}
