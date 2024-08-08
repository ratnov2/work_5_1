<?php

namespace App\Containers\LiveDrops\Listeners;

use App\Containers\LiveDrops\Events\NewLiveDropEvent;

class OnNewJackpotDropListener
{
    public function handle($event)
    {
        $player = $event->player;
        $item = $event->item;
        event(new NewLiveDropEvent(player:$player, item:$item, type:'jackpot'));
    }
}
