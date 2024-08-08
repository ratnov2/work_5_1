<?php

namespace App\Containers\RefSystem\Tasks;

use App\Containers\RefSystem\Models\RefLevel;

final class GetRefLevelsTask
{
    public function run()
    {
        return RefLevel::standart()->orderBy('level', 'desc')->get();
    }
}
