<?php

namespace App\Containers\PaymentSection\PaymentSystem\UI\API\Controllers;

use App\Http\Controllers\Controller;
use App\Containers\PaymentSection\PaymentSystem\DTO\ResultFreekassaDTO;
use App\Containers\PaymentSection\PaymentSystem\PaymentSystems\PaymentSystemManager;
use App\Containers\PaymentSection\PaymentSystem\UI\API\Requests\ResultFreekassaRequest;
use App\Containers\PaymentSection\Payment\Models\Payment;

class FreekassaController extends Controller
{
    public function result(ResultFreekassaRequest $request)
    {
        $dto = app(ResultFreekassaDTO::class)->fromRequest($request);
        $payment = Payment::firstWhere('id', $dto->getMERCHANT_ORDER_ID());
        $payment_system_manager = new PaymentSystemManager();
        $payment_system_manager->selectPayment($payment)->handleResult($dto);
    }
}
