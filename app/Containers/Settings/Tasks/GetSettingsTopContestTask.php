<?php

namespace App\Containers\Settings\Tasks;

use App\Containers\Settings\Models\SettingsTopContest;
use Illuminate\Support\Facades\Cache;

final class GetSettingsTopContestTask
{
    public function run()
    {
        return Cache::rememberForever('settings_top_contest', function () {
            return SettingsTopContest::first();
        });
    }
}
