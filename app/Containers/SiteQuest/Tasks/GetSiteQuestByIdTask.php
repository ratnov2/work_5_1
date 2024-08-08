<?php

namespace App\Containers\SiteQuest\Tasks;

use App\Containers\SiteQuest\Models\SiteQuest;

final class GetSiteQuestByIdTask
{
    public function run(int $id, $is_locked = false) : SiteQuest| null
    {
        $query = SiteQuest::where('id', $id);
        if($is_locked) $query = $query->lockForUpdate();
        return $query->first();
    }
}
