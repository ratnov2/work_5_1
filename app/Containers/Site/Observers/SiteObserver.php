<?php

namespace App\Containers\Site\Observers;

use Illuminate\Support\Facades\Cache;

class SiteObserver
{
    public function created()
    {
        Cache::forget('categories');
    }

    public function updated()
    {
        Cache::forget('categories');
    }

    public function deleted()
    {
        Cache::forget('categories');
    }

    public function restored()
    {
        Cache::forget('categories');
    }

    public function forceDeleted()
    {
        Cache::forget('categories');
    }
}
