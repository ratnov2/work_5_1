<?php

namespace App\Containers\Player\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PlayerAttachTelegramAccountEvent implements IPlayerAttachSocialAccount
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $account;
    public $social = 'telegram';

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($account)
    {
        $this->account = $account;
    }

}
