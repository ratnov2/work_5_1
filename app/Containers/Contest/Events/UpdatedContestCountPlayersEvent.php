<?php

namespace App\Containers\Contest\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Queue\SerializesModels;

class UpdatedContestCountPlayersEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $count_players;
    public $contest_id;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($contest)
    {
        $this->contest_id = $contest->id;
        $this->count_players = $contest->players()->count();
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('public:contest' . $this->contest_id);
    }
}
