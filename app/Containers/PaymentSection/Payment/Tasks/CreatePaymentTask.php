<?php

namespace App\Containers\PaymentSection\Payment\Tasks;

use App\Containers\PaymentSection\Payment\DTO\CreatePaymentDTO;
use App\Containers\PaymentSection\Payment\Models\Payment;

final class CreatePaymentTask
{
    public function run(CreatePaymentDTO $dto) : Payment
    {
        return Payment::create($dto->toArray());
    }
}
