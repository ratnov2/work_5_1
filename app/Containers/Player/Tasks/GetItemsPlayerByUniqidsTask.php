<?php

namespace App\Containers\Player\Tasks;

use Illuminate\Support\Facades\DB;

final class GetItemsPlayerByUniqidsTask
{
    public function run($is_locked = false, ...$uniqids)
    {
        $query = DB::table('item_player')->whereIn('uniqid', $uniqids);
        if($is_locked) $query = $query->lockForUpdate();
        return $query->get();
    }
}
