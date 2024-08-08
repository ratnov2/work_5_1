<?php

namespace App\Containers\PaymentSection\Payment\UI\API\Controllers;

use App\Containers\PaymentSection\Payment\Exceptions\PaymentException;
use App\Containers\PaymentSection\Payment\Tasks\GetPaymentPromocodeByValueTask;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function checkPromocode(Request $request)
    {
        if(!$request->has('promocode_value')) throw new PaymentException('Укажите промокод');

        $promocode = app(GetPaymentPromocodeByValueTask::class)->run(false, $request->promocode_value);
        if(!$promocode) throw new PaymentException('Проомокод не найден');

        return response()->json([
            'status' => 'success',
            'promocode' => $promocode
        ]);
    }
}
