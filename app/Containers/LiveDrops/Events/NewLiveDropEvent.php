<?php

namespace App\Containers\LiveDrops\Events;

use App\Containers\LiveDrops\UI\API\Resources\LiveDropResource;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewLiveDropEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $live_drop = null;
    public $uid;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(...$params)
    {
        $params = (object) $params;

        $this->live_drop = new LiveDropResource($params);
        $this->uid = uniqid();
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('public:live-drops');
    }
}
