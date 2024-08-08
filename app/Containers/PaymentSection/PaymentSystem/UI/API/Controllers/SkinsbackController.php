<?php

namespace App\Containers\PaymentSection\PaymentSystem\UI\API\Controllers;

use App\Http\Controllers\Controller;
use App\Containers\PaymentSection\PaymentSystem\DTO\ResultSkinsbackDTO;
use App\Containers\PaymentSection\Payment\Models\Payment;
use App\Containers\PaymentSection\PaymentSystem\PaymentSystems\PaymentSystemManager;
use App\Containers\PaymentSection\PaymentSystem\UI\API\Requests\ResultSkinsbackRequest;

class SkinsbackController extends Controller
{
    public function result(ResultSkinsbackRequest $request)
    {
        $dto = app(ResultSkinsbackDTO::class)->fromRequest($request);
        $payment = Payment::firstWhere('id', $dto->getOrder_id());
        $payment_system_manager = new PaymentSystemManager();
        $payment_system_manager->selectPayment($payment)->handleResult($dto);
    }
}
