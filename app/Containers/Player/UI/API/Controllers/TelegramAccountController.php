<?php

namespace App\Containers\Player\UI\API\Controllers;

use App\Containers\Player\Actions\DettachTelegramAccountAction;
use App\Http\Controllers\Controller;

class TelegramAccountController extends Controller
{
    public function dettach()
    {
        app(DettachTelegramAccountAction::class)->run();

        return response()->json([
            'status' => 'success',
            'msg' => 'Аккаунт Telegram успешно отвязан!'
        ]);
    }
}
