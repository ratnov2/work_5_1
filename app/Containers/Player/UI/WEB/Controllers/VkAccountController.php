<?php

namespace App\Containers\Player\UI\WEB\Controllers;

use App\Containers\Player\Actions\AttachVkAccountAction;
use App\Containers\Player\Actions\GetAuthVkAccountURLAction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VkAccountController extends Controller
{
    public function auth()
    {
        $url = app(GetAuthVkAccountURLAction::class)->run();

        return redirect()->to($url);
    }

    public function attach(Request $request)
    {
        $request->validate([
            'code' => 'required'
        ]);

        app(AttachVkAccountAction::class)->run($request->code);

        return redirect()->to('/')->with([
            'status' => 'success',
            'msg' => 'Аккаунт VK успешно привязан!'
        ]);
    }
}
