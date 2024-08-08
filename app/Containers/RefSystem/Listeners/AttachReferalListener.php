<?php

namespace App\Containers\RefSystem\Listeners;

use App\Containers\Player\Events\PlayerRegisteredEvent;
use App\Containers\Player\Models\Player;
use App\Containers\RefSystem\Models\RefLevel;

class AttachReferalListener
{
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(PlayerRegisteredEvent $event)
    {
        $player = $event->player;

        $first_ref_level = RefLevel::where([['level', 1], ['type', 'standart']])->first();
        $player->ref_level_id = $first_ref_level->id;

        if(session()->has('ref')) { // Рефералка
            $referrer_ref_code = session()->get('ref');
            $referrer = Player::where('ref_code', $referrer_ref_code)->orWhere('steam_id', $referrer_ref_code)->first();
            if($referrer && $referrer->id != $player->id) {
                $player->referrer_id = $referrer->id;
            }
        }

        $player->save();
    }
}
