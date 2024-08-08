<?php

namespace App\Containers\PaymentSection\PaymentSystem\UI\API\Controllers;

use App\Http\Controllers\Controller;
use App\Containers\PaymentSection\PaymentSystem\DTO\ResultEnotDTO;
use App\Containers\PaymentSection\PaymentSystem\PaymentSystems\PaymentSystemManager;
use App\Containers\PaymentSection\PaymentSystem\UI\API\Requests\ResultEnotRequest;
use App\Containers\PaymentSection\Payment\Models\Payment;
use Illuminate\Support\Facades\Log;

class EnotController extends Controller
{
    public function result(ResultEnotRequest $request)
    {
        try {
            $dto = app(ResultEnotDTO::class)->fromRequest($request);
            $payment = Payment::firstWhere('id', $dto->merchant_id);
            $payment_system_manager = new PaymentSystemManager();
            $payment_system_manager->selectPayment($payment)->handleResult($dto);
        } catch (\Throwable $th) {
            Log::error('['.$th->getCode().']' . ' ' . get_class($th) . ' "' . $th->getMessage().'" on line ' . $th->getTrace()[0]['line'] . ' of file ' . $th->getTrace()[0]['file']);
            throw $th;
        }
    }
}
