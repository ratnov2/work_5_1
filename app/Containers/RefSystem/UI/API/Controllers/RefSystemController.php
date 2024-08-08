<?php

namespace App\Containers\RefSystem\UI\API\Controllers;

use App\Http\Controllers\Controller;
use App\Containers\RefSystem\Actions\MakeRefBalanceWithdrawAction;
use App\Containers\RefSystem\Actions\SetRefCodeAction;
use Illuminate\Http\Request;

class RefSystemController extends Controller
{
    public function makeRefBalanceWithdraw(Request $request)
    {
        $request->validate([
            'sum' => 'required'
        ]);

        $result = app(MakeRefBalanceWithdrawAction::class)->run($request->sum);

        return response()->json([
            'status' => 'success',
            'msg' => 'Успешно выведено',
            'ref_balance' => $result['ref_balance'],
            'balance' => $result['balance']
        ]);
    }

    public function setRefCode(Request $request)
    {
        $request->validate([
            'ref_code' => 'required'
        ]);

        app(SetRefCodeAction::class)->run($request->ref_code);

        return response()->json([
            'status' => 'success',
            'msg' => 'Реф. код успешно обновлен'
        ]);
    }
}
