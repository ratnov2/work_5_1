<?php

namespace App\Containers\Settings\Observers;

use Illuminate\Support\Facades\Cache;

class SettingsTopContestObserver
{
    public function created()
    {
        Cache::forget('settings_top_contest');
    }

    public function updated()
    {
        Cache::forget('settings_top_contest');
    }

    public function deleted()
    {
        Cache::forget('settings_top_contest');
    }

    public function restored()
    {
        Cache::forget('settings_top_contest');
    }

    public function forceDeleted()
    {
        Cache::forget('settings_top_contest');
    }
}
