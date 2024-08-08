<?php

namespace App\Containers\LiveDrops\Listeners;

use App\Containers\LiveDrops\Events\NewLiveDropEvent;
// use App\Containers\LiveDrops\Jobs\DelayedNewLiveDropJob;

class OnNewUpgradeDropListener
{
    public function handle($event)
    {
        $player = $event->player;
        $item = $event->item;
        // dispatch(new DelayedNewLiveDropJob(player:$player, item:$item, type:'upgrade'))->delay(10);
        event(new NewLiveDropEvent(player:$player, item:$item, type:'upgrade')); // TASK
    }
}
