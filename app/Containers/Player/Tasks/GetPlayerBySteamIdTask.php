<?php

namespace App\Containers\Player\Tasks;

use App\Containers\Player\Models\Player;

final class GetPlayerBySteamIdTask
{
    public function run($steam_id) : Player | null
    {
        return Player::where('steam_id', $steam_id)->first();
    }
}
