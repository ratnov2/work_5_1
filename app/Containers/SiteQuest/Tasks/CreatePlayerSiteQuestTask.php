<?php

namespace App\Containers\SiteQuest\Tasks;

use App\Containers\SiteQuest\Models\PlayerSiteQuest;

final class CreatePlayerSiteQuestTask
{
    public function run($params) : PlayerSiteQuest
    {
        return PlayerSiteQuest::create($params);
    }
}
