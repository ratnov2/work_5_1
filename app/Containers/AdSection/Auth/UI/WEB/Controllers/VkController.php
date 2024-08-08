<?php

namespace App\Containers\AdSection\Auth\UI\WEB\Controllers;

use App\Containers\AdSection\Auth\Actions\GetAuthVkURLAction;
use App\Containers\AdSection\Auth\Actions\HandleAuthVkAction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VkController extends Controller
{
    public function login(Request $request)
    {
        session()->forget('ad_users_remember');
        if($request->remember && $request->remember === 'on') session(['ad_users_remember' => 'on']);

        $url = app(GetAuthVkURLAction::class)->run();

        return redirect()->to($url);
    }

    public function handle(Request $request)
    {
        $request->validate([
            'code' => 'required'
        ]);

        $user = app(HandleAuthVkAction::class)->run($request->code);

        $remember = session('ad_users_remember', 'off') === 'on';

        Auth::guard('ad_users')->login($user, $remember);

        return redirect()->route('ad.profile.index');
    }
}

