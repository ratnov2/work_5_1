<?php

namespace App\Containers\PaymentSection\PaymentSystem\DTO;

use App\DTO\DTO;

class PaymentFreekassaDTO extends DTO {
    public int $order_id;
    public float $order_amount;
    public string $currency = "RUB";
    public ?string $lang;
    public ?string $i;
}
