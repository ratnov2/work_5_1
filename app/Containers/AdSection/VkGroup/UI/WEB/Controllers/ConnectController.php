<?php

namespace App\Containers\AdSection\VkGroup\UI\WEB\Controllers;

use App\Containers\AdSection\VkGroup\Actions\ConnectAction;
use App\Containers\AdSection\VkGroup\Actions\HandleAction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ConnectController extends Controller
{
    public function connect(Request $request)
    {
        $request->validate([
            'group_ids' => 'required'
        ]);

        $url = app(ConnectAction::class)->run(...$request->group_ids);

        return redirect()->to($url);
    }

    public function handle(Request $request)
    {
        $request->validate([
            'code' => 'required'
        ]);

        app(HandleAction::class)->run($request->code);

        return redirect()->route('ad.profile.vk.groups');
    }
}

