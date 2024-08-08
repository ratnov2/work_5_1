<?php

namespace App\Containers\Pages\Actions;

use Illuminate\Support\Facades\View;

final class GetGameModesUpgradeViewAction
{
    public function run()
    {
        return View::make("pages::pages.gameModes.pages.upgrade.index")->render();
    }
}
