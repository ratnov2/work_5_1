<?php

namespace App\Containers\Player\UI\API\Controllers;

use App\Containers\Player\Actions\DettachVkAccountAction;
use App\Http\Controllers\Controller;

class VkAccountController extends Controller
{
    public function dettach()
    {
        app(DettachVkAccountAction::class)->run();

        return response()->json([
            'status' => 'success',
            'msg' => 'Аккаунт VK успешно отвязан!'
        ]);
    }
}
