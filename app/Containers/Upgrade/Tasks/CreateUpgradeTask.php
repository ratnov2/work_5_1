<?php

namespace App\Containers\Upgrade\Tasks;

use App\Containers\Upgrade\Models\Upgrade;

final class CreateUpgradeTask
{
    public function run($params) : Upgrade
    {
        return Upgrade::create($params);
    }
}
