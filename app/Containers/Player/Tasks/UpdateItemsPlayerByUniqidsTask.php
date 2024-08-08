<?php

namespace App\Containers\Player\Tasks;

use Illuminate\Support\Facades\DB;

final class UpdateItemsPlayerByUniqidsTask
{
    public function run($data, ...$uniqids)
    {
        return DB::table('item_player')->whereIn('uniqid', $uniqids)->update($data);
    }
}
