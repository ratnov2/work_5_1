<?php

namespace App\Containers\BoxUnique\DTO;

use App\DTO\DTO;

class OpenBoxPromocodableDTO extends DTO {

    protected $promocode_value;

    /**
     * Get the value of type
     */
    public function getPromocode_value()
    {
        return $this->promocode_value;
    }
}
