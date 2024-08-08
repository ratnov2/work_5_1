<?php

namespace App\Containers\Site\Observers;

use Illuminate\Support\Facades\Cache;

class SiteCategoryObserver
{
    public function created()
    {
        Cache::forget('site_categories');
    }

    /**
     * Handle the Category "updated" event.
     *
     * @param  \App\Models\Category  $category
     * @return void
     */
    public function updated()
    {
        Cache::forget('site_categories');
    }

    /**
     * Handle the Category "deleted" event.
     *
     * @param  \App\Models\Category  $category
     * @return void
     */
    public function deleted()
    {
        Cache::forget('site_categories');
    }

    /**
     * Handle the Category "restored" event.
     *
     * @param  \App\Models\Category  $category
     * @return void
     */
    public function restored()
    {
        Cache::forget('site_categories');
    }

    /**
     * Handle the Category "force deleted" event.
     *
     * @param  \App\Models\Category  $category
     * @return void
     */
    public function forceDeleted()
    {
        Cache::forget('site_categories');
    }
}
