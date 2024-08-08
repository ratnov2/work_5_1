<?php

namespace App\Containers\Upgrade\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewUpgradeDropEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $player;
    public $item;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($player, $item)
    {
        $this->player = $player;
        $this->item = $item;
    }
}
