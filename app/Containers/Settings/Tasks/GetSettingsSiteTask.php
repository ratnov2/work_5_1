<?php

namespace App\Containers\Settings\Tasks;

use App\Containers\Settings\Models\SettingsSite;
use Illuminate\Support\Facades\Cache;

final class GetSettingsSiteTask
{
    public function run()
    {
        return Cache::rememberForever('settings_site', function () {
            return SettingsSite::first();
        });
    }
}
