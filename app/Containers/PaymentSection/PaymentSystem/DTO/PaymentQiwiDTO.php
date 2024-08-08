<?php

namespace App\Containers\PaymentSection\PaymentSystem\DTO;

use App\DTO\DTO;

class PaymentQiwiDTO extends DTO {
    public int $billId;
    public $amount;
    public ?string $comment;
}
