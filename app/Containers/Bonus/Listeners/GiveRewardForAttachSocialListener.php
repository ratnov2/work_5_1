<?php

namespace App\Containers\Bonus\Listeners;

use App\Containers\Item\Tasks\GetItemLowerThanTask;
use App\Containers\Player\Events\IPlayerAttachSocialAccount;
use App\Containers\Player\SubActions\AddDropablePlayerItemsSubAction;

class GiveRewardForAttachSocialListener
{
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(IPlayerAttachSocialAccount $event)
    {
        $account = $event->account;

        $player = $account->player;

        if(!$player->items()->where('dropable_type', get_class($account))->exists()) {
            $item = app(GetItemLowerThanTask::class)->run(0.70);

            $player_item = app(AddDropablePlayerItemsSubAction::class)->run($player, $account, $item)[0];

            $messages = session('messages', []);

            $messages[] = 'Вы успешно получили ' . $player_item->market_hash_name . ' ! Так держать!';

            session()->flash('messages', $messages);
        }
    }
}
