<?php

namespace App\Containers\Settings\Tasks;

use App\Containers\Settings\Models\SettingsBox;
use Illuminate\Support\Facades\Cache;

final class GetSettingsBoxTask
{
    public function run()
    {
        return Cache::rememberForever('settings_box', function () {
            return SettingsBox::first();
        });
    }
}
