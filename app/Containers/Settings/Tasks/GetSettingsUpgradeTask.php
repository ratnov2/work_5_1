<?php

namespace App\Containers\Settings\Tasks;

use App\Containers\Settings\Models\SettingsUpgrade;
use Illuminate\Support\Facades\Cache;

final class GetSettingsUpgradeTask
{
    public function run()
    {
        return Cache::rememberForever('settings_upgrade', function () {
            return SettingsUpgrade::first();
        });
    }
}
