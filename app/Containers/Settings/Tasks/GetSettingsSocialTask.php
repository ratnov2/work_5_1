<?php

namespace App\Containers\Settings\Tasks;

use App\Containers\Settings\Models\SettingsSocial;
use Illuminate\Support\Facades\Cache;

final class GetSettingsSocialTask
{
    public function run()
    {
        return Cache::rememberForever('settings_socials', function () {
            return SettingsSocial::first();
        });
    }
}
