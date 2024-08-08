<?php

namespace App\Containers\Settings\Observers;

use Illuminate\Support\Facades\Cache;

class SettingsSocialObserver
{
    public function created()
    {
        Cache::forget('settings_socials');
    }

    public function updated()
    {
        Cache::forget('settings_socials');
    }

    public function deleted()
    {
        Cache::forget('settings_socials');
    }

    public function restored()
    {
        Cache::forget('settings_socials');
    }

    public function forceDeleted()
    {
        Cache::forget('settings_socials');
    }
}
