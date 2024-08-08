<?php

namespace App\Containers\Banner\Observers;

use Illuminate\Support\Facades\Cache;

class BannerObserver
{
    public function created()
    {
        Cache::forget('banners');
    }

    /**
     * Handle the Banner "updated" event.
     *
     * @param  \App\Models\Banner  $banner
     * @return void
     */
    public function updated()
    {
        Cache::forget('banners');
    }

    /**
     * Handle the Banner "deleted" event.
     *
     * @param  \App\Models\Banner  $banner
     * @return void
     */
    public function deleted()
    {
        Cache::forget('banners');
    }

    /**
     * Handle the Banner "restored" event.
     *
     * @param  \App\Models\Banner  $banner
     * @return void
     */
    public function restored()
    {
        Cache::forget('banners');
    }

    /**
     * Handle the Banner "force deleted" event.
     *
     * @param  \App\Models\Banner  $banner
     * @return void
     */
    public function forceDeleted()
    {
        Cache::forget('banners');
    }
}
