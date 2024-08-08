<?php

namespace App\Containers\GameModes\Tasks;

use App\Containers\GameModes\Models\Banks;

final class GetBankMinesTask
{
    public function run($is_locked = false)
    {
        $query = Banks::mines();
        if($is_locked) $query = $query->lockForUpdate();
        return $query->first();
    }
}
