<?php

namespace App\Containers\Shop\DTO;

use App\DTO\DTO;

class BuyItemsDTO extends DTO {

    protected $extra_uniqids;
    protected $market_hash_names_with_quantity;

    /**
     * Get the value of extra_uniqids
     */
    public function getExtra_uniqids()
    {
        return $this->extra_uniqids;
    }

    /**
     * Get the value of market_hash_names_with_quantity
     */
    public function getMarket_hash_names_with_quantity()
    {
        return $this->market_hash_names_with_quantity;
    }
}
