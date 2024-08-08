<?php

namespace App\Containers\Settings\Tasks;

use App\Containers\Settings\Models\SettingsPaymentSystem;
use Illuminate\Support\Facades\Cache;

final class GetSettingsPaymentSystemTask
{
    public function run()
    {
        return Cache::rememberForever('settings_payment_systems', function () {
            return SettingsPaymentSystem::first();
        });
    }
}
