<?php

namespace App\Containers\PaymentSection\PaymentSystem\UI\API\Controllers;

use App\Http\Controllers\Controller;
use App\Containers\PaymentSection\PaymentSystem\DTO\ResultXmpayDTO;
use App\Containers\PaymentSection\Payment\Models\Payment;
use App\Containers\PaymentSection\PaymentSystem\PaymentSystems\PaymentSystemManager;
use App\Containers\PaymentSection\PaymentSystem\UI\API\Requests\ResultXmpayRequest;

class XmpayController extends Controller
{
    public function result(ResultXmpayRequest $request)
    {
        $dto = app(ResultXmpayDTO::class)->fromRequest($request);
        $payment = Payment::firstWhere('id', $dto->getLabel());
        $payment_system_manager = new PaymentSystemManager();
        $payment_system_manager->selectPayment($payment)->handleResult($dto);
    }
}
