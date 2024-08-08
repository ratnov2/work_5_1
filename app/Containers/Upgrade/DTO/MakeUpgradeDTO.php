<?php

namespace App\Containers\Upgrade\DTO;

use App\DTO\DTO;

class MakeUpgradeDTO extends DTO {

    protected $uniqid;
    protected $sync_chance;
    protected $wanted_market_hash_name;

    /**
     * Get the value of uniqid
     */
    public function getUniqid()
    {
        return $this->uniqid;
    }

    /**
     * Get the value of wanted_market_hash_name
     */
    public function getWanted_market_hash_name()
    {
        return $this->wanted_market_hash_name;
    }

    /**
     * Get the value of sync_chance
     */
    public function getSync_chance()
    {
        return $this->sync_chance;
    }
}
