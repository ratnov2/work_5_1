<?php

namespace App\Containers\Player\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PlayerRegisteredEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $player;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($player)
    {
        $this->player = $player;
    }

}
