<?php

namespace App\Containers\PaymentSection\PaymentSystem\DTO;

class ResultSkinsbackDTO extends ResultDTO {
    protected string $sign;
    protected string $status;
    protected string $steam_id;
    protected string $order_id;
    protected ?float $amount;
    protected ?string $amount_currency;
    protected ?object $amount_in_currencies;
    protected ?float $user_amount;
    protected ?object $user_amount_in_currencies;
    protected ?array $skins;

    /**
     * Get the value of sign
     */
    public function getSign()
    {
        return $this->sign;
    }

    /**
     * Get the value of status
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Get the value of steam_id
     */
    public function getSteam_id()
    {
        return $this->steam_id;
    }

    /**
     * Get the value of order_id
     */
    public function getOrder_id()
    {
        return $this->order_id;
    }

    /**
     * Get the value of amount
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Get the value of amount_currency
     */
    public function getAmount_currency()
    {
        return $this->amount_currency;
    }

    /**
     * Get the value of skins
     */
    public function getSkins()
    {
        return $this->skins;
    }

    /**
     * Get the value of user_amount_in_currencies
     */
    public function getUser_amount_in_currencies()
    {
        return $this->user_amount_in_currencies;
    }

    /**
     * Get the value of user_amount
     */
    public function getUser_amount()
    {
        return $this->user_amount;
    }

    /**
     * Get the value of amount_in_currencies
     */
    public function getAmount_in_currencies()
    {
        return $this->amount_in_currencies;
    }
}
