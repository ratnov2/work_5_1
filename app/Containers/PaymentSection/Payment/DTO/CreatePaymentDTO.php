<?php

namespace App\Containers\PaymentSection\Payment\DTO;

use App\DTO\DTO;

class CreatePaymentDTO extends DTO
{
    protected ?float $sum;
    protected ?int $promocode_id;
    protected int $player_id;
    protected string $paymentable_type;
    protected int $paymentable_id;

    /**
     * Get the value of sum
     */
    public function getSum()
    {
        return $this->sum;
    }

    /**
     * Get the value of player_id
     */
    public function getPlayer_id()
    {
        return $this->player_id;
    }

    /**
     * Get the value of promocode_id
     */
    public function getPromocode_id()
    {
        return $this->promocode_id;
    }

    /**
     * Get the value of paymentable_id
     */
    public function getPaymentable_id()
    {
        return $this->paymentable_id;
    }

    /**
     * Get the value of paymentable_type
     */
    public function getPaymentable_type()
    {
        return $this->paymentable_type;
    }
}

