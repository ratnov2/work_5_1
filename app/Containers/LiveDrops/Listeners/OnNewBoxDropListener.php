<?php

namespace App\Containers\LiveDrops\Listeners;

use App\Containers\LiveDrops\Events\NewLiveDropEvent;

class OnNewBoxDropListener
{
    public function handle($event)
    {
        $mode = $event->mode;
        $player = $event->player;
        $item = $event->item;

        event(new NewLiveDropEvent(player:$player, item:$item, type:'box'));
    }
}
