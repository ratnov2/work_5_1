<?php

namespace App\Containers\BoxMoney\UI\API\Controllers;

use App\Containers\BoxMoney\Actions\OpenBoxMoneyAction;
use App\Containers\BoxMoney\Requests\OpenBoxMoneyRequest;
use App\Http\Controllers\Controller;

class BoxMoneyController extends Controller
{
    public function openBoxMoney(OpenBoxMoneyRequest $request)
    {
        $data = app(OpenBoxMoneyAction::class)->run($request->mode, $request->box_id);

        return response()->json([
            'status' => 'success',
            'data' => $data,
        ]);
    }
}

