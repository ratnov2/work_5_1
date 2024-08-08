<?php

namespace App\Containers\Box\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewBoxDropEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $mode;
    public $player;
    public $item;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($mode, $player, $item)
    {
        $this->mode = $mode;
        $this->player = $player;
        $this->item = $item;
    }
}
