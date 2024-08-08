<?php

namespace App\Containers\Withdraw\DTO;

use App\DTO\DTO;

class ItemWithdrawDTO extends DTO {

    protected $uniqid;

    /**
     * Get the value of uniqid
     */
    public function getUniqid()
    {
        return $this->uniqid;
    }
}
