<?php

namespace App\Containers\Jackpot\Events;

use App\Containers\Jackpot\UI\API\Resources\JackpotHistoryResource;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewJackpotHistory implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $jackpot;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(JackpotHistoryResource $jackpot)
    {
        $this->jackpot = $jackpot;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('public:jackpot_history');
    }
}
