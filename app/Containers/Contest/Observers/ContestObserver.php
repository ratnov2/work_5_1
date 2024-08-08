<?php

namespace App\Containers\Contest\Observers;

use Illuminate\Support\Facades\Cache;

class ContestObserver
{
    public function created()
    {
        Cache::forget('finish_contests');
    }

    /**
     * Handle the Contest "updated" event.
     *
     * @param  \App\Models\Contest  $contest
     * @return void
     */
    public function updated()
    {
        Cache::forget('finish_contests');
    }

    /**
     * Handle the Contest "deleted" event.
     *
     * @param  \App\Models\Contest  $contest
     * @return void
     */
    public function deleted()
    {
        Cache::forget('finish_contests');
    }

    /**
     * Handle the Contest "restored" event.
     *
     * @param  \App\Models\Contest  $contest
     * @return void
     */
    public function restored()
    {
        Cache::forget('finish_contests');
    }

    /**
     * Handle the Contest "force deleted" event.
     *
     * @param  \App\Models\Contest  $contest
     * @return void
     */
    public function forceDeleted()
    {
        Cache::forget('finish_contests');
    }
}
