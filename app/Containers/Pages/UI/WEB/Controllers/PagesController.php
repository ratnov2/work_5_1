<?php

namespace App\Containers\Pages\UI\WEB\Controllers;

use App\Containers\Pages\Actions\GetSPAViewAction;
use App\Http\Controllers\Controller;

class PagesController extends Controller
{
    public function spa()
    {
        return app(GetSPAViewAction::class)->run();
    }
}
