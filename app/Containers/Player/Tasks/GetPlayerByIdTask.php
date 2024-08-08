<?php

namespace App\Containers\Player\Tasks;

use App\Containers\Player\Models\Player;

final class GetPlayerByIdTask
{
    public function run($id, $is_locked = false) : Player | null
    {
        $query = Player::where('id', $id);
        if($is_locked) $query = $query->lockForUpdate();
        return $query->first();
    }
}
