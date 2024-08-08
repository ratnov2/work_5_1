<?php

namespace App\Containers\RefSystem\Tasks;

use App\Containers\RefSystem\Models\RefLevel;

final class GetStartRefLevelTask
{
    public function run()
    {
        return RefLevel::start()->first();
    }
}
