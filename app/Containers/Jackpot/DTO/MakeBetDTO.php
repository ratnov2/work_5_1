<?php

namespace App\Containers\Jackpot\DTO;

use App\DTO\DTO;

class MakeBetDTO extends DTO {

    protected $uniqids;

    /**
     * Get the value of uniqids
     */
    public function getUniqids()
    {
        return $this->uniqids;
    }
}
