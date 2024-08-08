<?php

namespace App\Containers\SiteQuest\Tasks;

use App\Containers\SiteQuest\Models\PlayerSiteQuest;

final class GetPlayerSiteQuestsTask
{
    public function run($player)
    {
        return PlayerSiteQuest::where('player_id', $player->id)->get();
    }
}
