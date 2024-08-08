<?php

namespace App\Containers\Pages\Actions;

use App\Containers\Settings\Tasks\GetSettingsSiteTask;
use Illuminate\Support\Facades\View;

final class GetSPAViewAction
{
    public function run()
    {
        $settings_site = app(GetSettingsSiteTask::class)->run()->toArray();

        return View::make('pages::spa', $settings_site);
    }
}
