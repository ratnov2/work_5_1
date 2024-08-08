<?php

namespace App\Containers\Settings\Observers;

use Illuminate\Support\Facades\Cache;

class SettingsJackpotObserver
{
    public function created()
    {
        Cache::forget('settings_jackpot');
    }

    public function updated()
    {
        Cache::forget('settings_jackpot');
    }

    public function deleted()
    {
        Cache::forget('settings_jackpot');
    }

    public function restored()
    {
        Cache::forget('settings_jackpot');
    }

    public function forceDeleted()
    {
        Cache::forget('settings_jackpot');
    }
}
