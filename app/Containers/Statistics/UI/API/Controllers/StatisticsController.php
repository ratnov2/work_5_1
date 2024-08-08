<?php

namespace App\Containers\Statistics\UI\API\Controllers;

use App\Containers\Statistics\Actions\GetStatisticsAction;
use App\Http\Controllers\Controller;

class StatisticsController extends Controller
{
    public function statistics()
    {
        $result = app(GetStatisticsAction::class)->run();

        return response()->json($result);
    }
}
