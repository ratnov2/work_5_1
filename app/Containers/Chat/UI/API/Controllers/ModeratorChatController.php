<?php

namespace App\Containers\Chat\UI\API\Controllers;

use App\Http\Controllers\Controller;
use App\Containers\Chat\Services\ChatService;
use App\Containers\Chat\UI\API\Requests\Moderator\MessageDeleteRequest;
use App\Containers\Chat\UI\API\Requests\Moderator\PlayerMuteRequest;
use App\Containers\Chat\UI\API\Requests\Moderator\PlayerUnmuteRequest;
use App\Containers\Player\Models\Player;
use App\Containers\Player\Tasks\GetPlayerByIdTask;
use denis660\Centrifugo\Centrifugo;

class ModeratorChatController extends Controller
{
    public $chat_service;

    public function __construct(ChatService $chat_service) {
        $this->chat_service = $chat_service;
    }

    public function playerUnmute(PlayerUnmuteRequest $request)
    {
        $player = Player::find($request->player_id);
        $this->chat_service->unmutePlayer($player);

        return response()->json([
            'status' => 'success',
            'msg' => "Игрок " . $player->name . " успешно размутен"
        ]);
    }

    public function playerMute(PlayerMuteRequest $request)
    {
        $player = app(GetPlayerByIdTask::class)->run($request->player_id);
        $seconds = $request->seconds;
        $this->chat_service->mutePlayer($player, $seconds);

        return response()->json([
            'status' => 'success',
            'msg' => "Игрок " . $player->name . " успешно заглушен на " . $seconds . " секунд(-ы)"
        ]);
    }

    public function messageDelete(MessageDeleteRequest $request, Centrifugo $centrifugo)
    {
        $centrifugo->publish('public:chat', [
            'type' => 'message_delete',
            'uid' => $request->uid,
        ]);

        return response()->json([
            'status' => 'success',
            'msg' => 'Сообщение успешно удалено'
        ]);
    }
}
