<?php

namespace App\Containers\Player\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SendStorePlayerEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $player_id;
    public $add_player_items;
    public $balance;
    public $msg;
    public $timestamp;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($player_id, $add_player_items = null, $balance = null, $msg = null)
    {
        $this->player_id = $player_id;
        $this->add_player_items = $add_player_items;
        $this->balance = $balance;
        $this->msg = $msg;
        $this->timestamp = \Carbon\Carbon::now()->getPreciseTimestamp(3);
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('private:player#' . $this->player_id);
    }
}
