<?php

namespace App\Containers\GameModes\Tasks;

use App\Containers\GameModes\Models\Banks;

final class GetBankBoxesMoneyTask
{
    public function run($is_locked = false)
    {
        $query = Banks::boxesMoney();
        if($is_locked) $query = $query->lockForUpdate();
        return $query->first();
    }
}
