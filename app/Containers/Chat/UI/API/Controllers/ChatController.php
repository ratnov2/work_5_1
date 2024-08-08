<?php

namespace App\Containers\Chat\UI\API\Controllers;

use App\Http\Controllers\Controller;
use App\Containers\Chat\Exceptions\API\ChatException;
use App\Containers\Chat\Services\ChatService;
use App\Containers\Chat\UI\API\Requests\SendRequest;
use App\Containers\Player\Tasks\GetAuthPlayerTask;
use App\Containers\Player\UI\API\Resources\SafePlayerResource;
use denis660\Centrifugo\Centrifugo;
use Illuminate\Support\Facades\RateLimiter;

class ChatController extends Controller
{
    const MAX_ATTEMPTS = 1;
    const MAX_ATTEMPTS_INTERVAL_SECONDS = 3;
    const BOX_PROMOCODES_MUTE_SECONDS = 60;

    public $chat_service;

    public function __construct(ChatService $chat_service) {
        $this->chat_service = $chat_service;
    }

    public function send(SendRequest $request, Centrifugo $centrifugo)
    {
        $player = app(GetAuthPlayerTask::class)->run();
        $msg = $request->msg;

        // Flood
        $executed = RateLimiter::attempt('chat-attempt-send-message:' . $player->id, self::MAX_ATTEMPTS,
            function() use($player, $msg, $centrifugo) {
                // Mute
                if($this->chat_service->checkMute($player)) {
                    $mute = $this->chat_service->getMuteInfo($player);
                    $seconds = $mute['seconds'] - \Carbon\Carbon::now()->diffInSeconds($mute['date']);
                    $interval = \Carbon\CarbonInterval::seconds($seconds)->cascade()->forHumans();
                    throw new ChatException('Отправка сообщений ограничена. До снятия ограничения осталось: ' . $interval);
                }

                $centrifugo->publish('public:chat', [
                    'type' => 'new_message',
                    'msg' => $msg,
                    'player' => new SafePlayerResource($player),
                    'time' => \Carbon\Carbon::now()->timestamp,
                    'uid' => uniqid(),
                ]);

            }, self::MAX_ATTEMPTS_INTERVAL_SECONDS);

        if (!$executed) throw new ChatException('Ограничение отправки сообщений: 1 раз в 3 секунды');

        return response()->json([
            'status' => 'success'
        ]);
    }
}
