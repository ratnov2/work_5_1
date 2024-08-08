<?php

namespace App\Containers\AdSection\Auth\UI\WEB\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function logout()
    {
        Auth::guard('ad_users')->logout();

        return redirect(route('ad.login.view'));
    }
}

