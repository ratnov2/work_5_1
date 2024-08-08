<?php

namespace App\Containers\PaymentSection\PaymentSystem\DTO;

use App\DTO\DTO;

class PaymentXmpayDTO extends DTO
{
    public string $label;
    public string $amount;
    public ?string $method;

    /**
     * Get the value of label
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Get the value of amount
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Get the value of method
     */
    public function getMethod()
    {
        return $this->method;
    }
}
