<?php

namespace App\Containers\PaymentSection\PaymentSystem\DTO;

use App\DTO\DTO;

class MakePaymentDTO extends DTO
{
    protected ?float $sum;
    protected ?string $promocode_value;
    protected int $player_id;
    protected int $payment_system_direction_id;

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
     * Get the value of payment_system_direction_id
     */
    public function getPayment_system_direction_id()
    {
        return $this->payment_system_direction_id;
    }

    /**
     * Get the value of promocode_value
     */
    public function getPromocode_value()
    {
        return $this->promocode_value;
    }
}

