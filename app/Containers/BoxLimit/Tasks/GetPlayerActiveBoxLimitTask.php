<?php

namespace App\Containers\BoxLimit\Tasks;

use App\Containers\BoxLimit\Models\BoxLimit;

final class GetPlayerActiveBoxLimitTask
{
    public function run($player, $is_locked = false)
    {
        return BoxLimit::active()->whereNotIn('boxes_limit.id', $player->boxes_limit()->pluck('boxes_limit.id')->toArray())->get();
    }
}
