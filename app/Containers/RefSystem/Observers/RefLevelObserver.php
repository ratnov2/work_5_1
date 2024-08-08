<?php

namespace App\Containers\RefSystem\Observers;

use Illuminate\Support\Facades\Cache;

class RefLevelObserver
{
    public function created()
    {
        Cache::forget('ref_levels');
    }

    /**
     * Handle the Banner "updated" event.
     *
     * @param  \App\Models\Banner  $banner
     * @return void
     */
    public function updated()
    {
        Cache::forget('ref_levels');
    }

    /**
     * Handle the Banner "deleted" event.
     *
     * @param  \App\Models\Banner  $banner
     * @return void
     */
    public function deleted()
    {
        Cache::forget('ref_levels');
    }

    /**
     * Handle the Banner "restored" event.
     *
     * @param  \App\Models\Banner  $banner
     * @return void
     */
    public function restored()
    {
        Cache::forget('ref_levels');
    }

    /**
     * Handle the Banner "force deleted" event.
     *
     * @param  \App\Models\Banner  $banner
     * @return void
     */
    public function forceDeleted()
    {
        Cache::forget('ref_levels');
    }
}
