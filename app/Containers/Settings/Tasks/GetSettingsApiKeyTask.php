<?php

namespace App\Containers\Settings\Tasks;

use App\Containers\Settings\Models\SettingsApiKey;
use Illuminate\Support\Facades\Cache;

final class GetSettingsApiKeyTask
{
    public function run()
    {
        return Cache::rememberForever('settings_api_keys', function () {
            return SettingsApiKey::first();
        });
    }
}
