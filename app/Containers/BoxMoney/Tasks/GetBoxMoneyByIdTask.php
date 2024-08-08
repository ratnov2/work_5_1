<?php

namespace App\Containers\BoxMoney\Tasks;

use App\Containers\BoxMoney\Models\BoxMoney;

final class GetBoxMoneyByIdTask
{
    public function run(int $id, $is_locked = false) : BoxMoney| null
    {
        $query = BoxMoney::where('id', $id);
        if($is_locked) $query = $query->lockForUpdate();
        return $query->first();
    }
}
