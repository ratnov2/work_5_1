<?php

namespace App\Containers\Player\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewDropableItemsPlayerEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $player_items;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($player_items)
    {
        $this->player_items = $player_items;
    }

}
