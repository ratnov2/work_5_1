<?php

namespace App\Containers\AdSection\User\Tasks;

use App\Containers\AdSection\User\Models\User;
use Illuminate\Support\Facades\Auth;

final class GetAuthUserTask
{
    public function run($is_locked = false) : User|null
    {
        $query = User::where('id', Auth::guard('ad_users')->id());
        if($is_locked) $query = $query->lockForUpdate();
        return $query->first();
    }
}
