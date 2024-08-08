<?php

namespace App\Containers\Settings\Observers;

use Illuminate\Support\Facades\Cache;

class SettingsSiteObserver
{
    public function created()
    {
        Cache::forget('settings_site');
    }

    public function updated()
    {
        Cache::forget('settings_site');
    }

    public function deleted()
    {
        Cache::forget('settings_site');
    }

    public function restored()
    {
        Cache::forget('settings_site');
    }

    public function forceDeleted()
    {
        Cache::forget('settings_site');
    }
}
