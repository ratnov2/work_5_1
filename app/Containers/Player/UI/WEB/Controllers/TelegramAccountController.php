<?php

namespace App\Containers\Player\UI\WEB\Controllers;

use App\Containers\Player\Actions\GetAuthTelegramViewAction;
use App\Containers\Player\Actions\AttachTelegramAccountAction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TelegramAccountController extends Controller
{
    public function auth()
    {
        return app(GetAuthTelegramViewAction::class)->run();
    }

    public function attach(Request $request)
    {
        app(AttachTelegramAccountAction::class)->run($request->all());

        return redirect()->to('/')->with([
            'status' => 'success',
            'msg' => 'Аккаунт Telegram успешно привязан!'
        ]);
    }
}
