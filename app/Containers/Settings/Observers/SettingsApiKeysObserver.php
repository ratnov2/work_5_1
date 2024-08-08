<?php

namespace App\Containers\Settings\Observers;

use Illuminate\Support\Facades\Cache;

class SettingsApiKeysObserver
{
    public function created()
    {
        Cache::forget('settings_api_keys');
    }

    public function updated()
    {
        Cache::forget('settings_api_keys');
    }

    public function deleted()
    {
        Cache::forget('settings_api_keys');
    }

    public function restored()
    {
        Cache::forget('settings_api_keys');
    }

    public function forceDeleted()
    {
        Cache::forget('settings_api_keys');
    }
}
