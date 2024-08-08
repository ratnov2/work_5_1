<?php

namespace App\Containers\PaymentSection\PaymentSystem\PaymentSystems;

use App\Containers\PaymentSection\PaymentSystem\Interfaces\PaymentSystemInterface;
use App\Containers\PaymentSection\Handle\Tasks\HandleResultPaymentTask;
use App\Containers\PaymentSection\Handle\Tasks\HandleSuccessPaymentTask;

abstract class AbstractPaymentSystem implements PaymentSystemInterface
{
    abstract function makePayment();

    public function handleResult($dto)
    {
        return app(HandleResultPaymentTask::class)->run($this->payment);
    }

    public function handleSuccess()
    {
        return app(HandleSuccessPaymentTask::class)->run($this->payment);
    }

    public function selectPayment($payment)
    {
        $this->payment = $payment;
        return $this;
    }
}
