<?php

namespace App\Containers\PaymentSection\Handle\Tasks;

use App\Containers\PaymentSection\Handle\Exceptions\HandleException;

final class HandleResultPaymentTask
{
    public function run($payment)
    {
        if ($payment->status != $payment::STATUS_WAITING) throw new HandleException('Данный платеж уже оплачен');
    }
}
