<?php

namespace App\Containers\BoxUnique\DTO;

use App\DTO\DTO;

class ResultOpenBoxPromocodableDTO extends DTO {
    protected $win_item;

    /**
     * Get the value of win_item
     */
    public function getWin_item()
    {
        return $this->win_item;
    }
}
