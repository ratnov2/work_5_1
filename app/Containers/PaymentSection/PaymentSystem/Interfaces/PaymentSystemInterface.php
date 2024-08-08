<?php

namespace App\Containers\PaymentSection\PaymentSystem\Interfaces;

interface PaymentSystemInterface {
    public function makePayment();
    public function handleResult($dto);
}
