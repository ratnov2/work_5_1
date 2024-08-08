<?php

namespace App\Containers\Pages\Actions;

use Illuminate\Support\Facades\View;

final class GetGameModesViewAction
{
    public function run()
    {
        $page = View::make("pages::pages.gameModes.index")->render();
        return $page;
    }
}
