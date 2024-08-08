<?php

namespace App\Containers\BoxUnique\Tasks;

use App\Containers\BoxUnique\Models\BoxPromocode;

final class GetBoxPromocodeByValueTask
{
    public function run(string $value, $is_locked = false) : BoxPromocode | null
    {
        $query = BoxPromocode::whereValue($value);
        if($is_locked) $query = $query->lockForUpdate();
        return $query->first();
    }
}
