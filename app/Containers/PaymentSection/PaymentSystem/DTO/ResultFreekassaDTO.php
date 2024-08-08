<?php

namespace App\Containers\PaymentSection\PaymentSystem\DTO;

class ResultFreekassaDTO extends ResultDTO {
    protected string $SIGN;
    protected string $MERCHANT_ID;
    protected string $MERCHANT_ORDER_ID;
    protected string $AMOUNT;

    /**
     * Get the value of SIGN
     */
    public function getSIGN()
    {
        return $this->SIGN;
    }

    /**
     * Get the value of MERCHANT_ID
     */
    public function getMERCHANT_ID()
    {
        return $this->MERCHANT_ID;
    }

    /**
     * Get the value of MERCHANT_ORDER_ID
     */
    public function getMERCHANT_ORDER_ID()
    {
        return $this->MERCHANT_ORDER_ID;
    }

    /**
     * Get the value of AMOUNT
     */
    public function getAMOUNT()
    {
        return $this->AMOUNT;
    }
}
