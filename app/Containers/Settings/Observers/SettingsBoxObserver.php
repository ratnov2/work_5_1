<?php

namespace App\Containers\Settings\Observers;

use Illuminate\Support\Facades\Cache;

class SettingsBoxObserver
{
    public function created()
    {
        Cache::forget('settings_box');
    }

    public function updated()
    {
        Cache::forget('settings_box');
    }

    public function deleted()
    {
        Cache::forget('settings_box');
    }

    public function restored()
    {
        Cache::forget('settings_box');
    }

    public function forceDeleted()
    {
        Cache::forget('settings_box');
    }
}
