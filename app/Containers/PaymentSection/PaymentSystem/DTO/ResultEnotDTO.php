<?php

namespace App\Containers\PaymentSection\PaymentSystem\DTO;

class ResultEnotDTO extends ResultDTO {
    public int $merchant;
    public string $merchant_id;
    public float $amount;
    public string $sign;
    public string $sign_2;
    public string $currency;
}
