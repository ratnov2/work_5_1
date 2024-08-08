<?php

namespace App\Containers\Settings\Observers;

use Illuminate\Support\Facades\Cache;

class SettingsWithdrawObserver
{
    public function created()
    {
        Cache::forget('settings_withdraw');
    }

    public function updated()
    {
        Cache::forget('settings_withdraw');
    }

    public function deleted()
    {
        Cache::forget('settings_withdraw');
    }

    public function restored()
    {
        Cache::forget('settings_withdraw');
    }

    public function forceDeleted()
    {
        Cache::forget('settings_withdraw');
    }
}
