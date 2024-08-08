<?php

namespace App\Containers\Settings\Tasks;

use App\Containers\Settings\Models\SettingsJackpot;
use Illuminate\Support\Facades\Cache;

final class GetSettingsJackpotTask
{
    public function run()
    {
        return Cache::rememberForever('settings_jackpot', function () {
            return SettingsJackpot::first();
        });
    }
}
