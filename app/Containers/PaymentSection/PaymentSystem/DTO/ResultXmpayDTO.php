<?php

namespace App\Containers\PaymentSection\PaymentSystem\DTO;

class ResultXmpayDTO extends ResultDTO {
    protected string $id;
    protected string $label;
    protected string $amount;
    protected string $hash;
    protected string $method;
    protected string $shop_id;
    protected string $time;

    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

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
     * Get the value of hash
     */
    public function getHash()
    {
        return $this->hash;
    }

    /**
     * Get the value of method
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * Get the value of shop_id
     */
    public function getShop_id()
    {
        return $this->shop_id;
    }

    /**
     * Get the value of time
     */
    public function getTime()
    {
        return $this->time;
    }
}
