<?php

namespace App\Containers\Withdraw\DTO;

use App\DTO\DTO;

class MarketCSGOBuyForDTO extends DTO {
    protected $hash_name;
    protected $price;
    protected $partner;
    protected $token;
    protected ?string $custom_id;
}
