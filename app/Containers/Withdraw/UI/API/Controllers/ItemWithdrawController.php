<?php

namespace App\Containers\Withdraw\UI\API\Controllers;

use App\Http\Controllers\Controller;
use App\Containers\Withdraw\Actions\ItemWithdrawAction;
use App\Containers\Withdraw\DTO\ItemWithdrawDTO;
use App\Containers\Withdraw\UI\API\Requests\ItemWithdrawRequest;

class ItemWithdrawController extends Controller
{
    public function itemWithdraw(ItemWithdrawRequest $request)
    {
        $dto = app(ItemWithdrawDTO::class)->fromRequest($request);
        app(ItemWithdrawAction::class)->run($dto);

        return response()->json([
            'status' => 'success',
            'msg' => 'Предмет поставлен на вывод'
        ]);
    }
}
