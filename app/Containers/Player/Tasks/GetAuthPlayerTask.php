<?php

namespace App\Containers\Player\Tasks;

use App\Containers\Player\Models\Player;
use Illuminate\Support\Facades\Auth;

final class GetAuthPlayerTask
{
    public function run($is_locked = false, $with = []) : Player|null
    {
        $query = Player::where('id', Auth::guard('players')->id());
        if($is_locked) $query = $query->lockForUpdate();
        if(!empty($with)) $query = $query->with($with);
        return $query->first();
    }
}
