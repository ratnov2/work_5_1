<?php

namespace App\Containers\Development\UI\WEB\Controllers;

use App\Containers\Player\Models\Player;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DevController extends Controller
{
    public function fakeAuth(int $id)
    {
        $player = Player::find($id);

        Auth::guard('players')->logout();
        Auth::guard('players')->login($player);

        return redirect()->to('/');
    }
}

