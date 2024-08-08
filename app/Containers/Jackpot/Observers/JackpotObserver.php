<?php

namespace App\Containers\Jackpot\Observers;

use Illuminate\Support\Facades\Cache;

class JackpotObserver
{
    public function created()
    {
        Cache::forget('jackpots_history');
    }

    public function updated()
    {
        Cache::forget('jackpots_history');
    }

    public function deleted()
    {
        Cache::forget('jackpots_history');
    }

    public function restored()
    {
        Cache::forget('jackpots_history');
    }

    public function forceDeleted()
    {
        Cache::forget('jackpots_history');
    }
}
