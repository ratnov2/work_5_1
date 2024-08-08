<?php

namespace App\Containers\Chat\Services;

use App\Containers\BoxUnique\Models\BoxPromocode;
use App\Containers\Player\Models\Player;
use Illuminate\Support\Facades\Cache;

class ChatService
{
    public function mutePlayer(Player $player, $mute_seconds = 60)
    {
        return Cache::put('chat-mute-player:' . $player->id, ['date' => \Carbon\Carbon::now(), 'seconds' => $mute_seconds], $mute_seconds);
    }

    public function unmutePlayer(Player $player)
    {
        return Cache::forget('chat-mute-player:' . $player->id);
    }

    public function checkMute(Player $player)
    {
        return Cache::has('chat-mute-player:' . $player->id);
    }

    public function getMuteInfo(Player $player)
    {
        return Cache::get('chat-mute-player:' . $player->id);
    }

    public function checkPromocodes($msg)
    {
        $active_box_promocode_values = BoxPromocode::active()->pluck('value')->toArray();
        return in_array($msg, $active_box_promocode_values);
    }
}


