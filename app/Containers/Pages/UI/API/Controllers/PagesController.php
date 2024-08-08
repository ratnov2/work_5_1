<?php

namespace App\Containers\Pages\UI\API\Controllers;

use App\Containers\Pages\Actions\GetBonusesViewAction;
use App\Containers\Pages\Actions\GetBoxesViewAction;
use App\Containers\Pages\Actions\GetContestsViewAction;
use App\Containers\Pages\Actions\GetGameModesViewAction;
use App\Containers\Pages\Actions\GetNotificationsViewAction;
use App\Containers\Pages\Actions\GetProfileViewAction;
use App\Containers\Pages\Actions\GetRefSystemViewAction;
use App\Containers\Pages\Actions\GetSiteQuestViewAction;
use App\Containers\Pages\Actions\GetSPAViewAction;
use App\Containers\Pages\Actions\GetGameModesBoxesViewAction;
use App\Containers\Pages\Actions\GetGameModesBoxViewAction;
use App\Containers\Pages\Actions\GetGameModesJackpotViewAction;
use App\Containers\Pages\Actions\GetGameModesMinesViewAction;
use App\Containers\Pages\Actions\GetGameModesTopContestViewAction;
use App\Containers\Pages\Actions\GetGameModesUpgradeViewAction;
use App\Containers\Pages\Actions\GetSteamPaymentViewAction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function serverTimestamp()
    {
        return \Carbon\Carbon::now()->getPreciseTimestamp(3);
    }
    
    public function spa()
    {
        return app(GetSPAViewAction::class)->run();
    }

    public function bonuses()
    {
        $page = app(GetBonusesViewAction::class)->run();

        return response()->json([
            'status' => 'success',
            'page' => $page
        ]);
    }

    public function boxes()
    {
        $page = app(GetBoxesViewAction::class)->run();

        return response()->json([
            'status' => 'success',
            'page' => $page
        ]);
    }

    public function contests()
    {
        $page = app(GetContestsViewAction::class)->run();

        return response()->json([
            'status' => 'success',
            'page' => $page
        ]);
    }

    public function gameModes()
    {
        $page = app(GetGameModesViewAction::class)->run();

        return response()->json([
            'status' => 'success',
            'page' => $page
        ]);
    }

    public function notifications()
    {
        $page = app(GetNotificationsViewAction::class)->run();

        return response()->json([
            'status' => 'success',
            'page' => $page
        ]);
    }

    public function profile()
    {
        $page = app(GetProfileViewAction::class)->run();

        return response()->json([
            'status' => 'success',
            'page' => $page
        ]);
    }

    public function refSystem()
    {
        $page = app(GetRefSystemViewAction::class)->run();

        return response()->json([
            'status' => 'success',
            'page' => $page
        ]);
    }

    public function site(Request $request)
    {
        $page = app(GetSiteQuestViewAction::class)->run($request->id);

        return response()->json([
            'status' => 'success',
            'page' => $page
        ]);
    }

    public function gameModesTopContest()
    {
        $page = app(GetGameModesTopContestViewAction::class)->run();

        return response()->json([
            'status' => 'success',
            'page' => $page
        ]);
    }

    public function gameModesJackpot()
    {
        $page = app(GetGameModesJackpotViewAction::class)->run();

        return response()->json([
            'status' => 'success',
            'page' => $page
        ]);
    }

    public function gameModesUpgrade()
    {
        $page = app(GetGameModesUpgradeViewAction::class)->run();

        return response()->json([
            'status' => 'success',
            'page' => $page
        ]);
    }

    public function gameModesBoxes()
    {
        $page = app(GetGameModesBoxesViewAction::class)->run();

        return response()->json([
            'status' => 'success',
            'page' => $page
        ]);
    }

    public function gameModesBox(Request $request)
    {
        $page = app(GetGameModesBoxViewAction::class)->run($request->id);

        return response()->json([
            'status' => 'success',
            'page' => $page
        ]);
    }

    public function gameModesMines()
    {
        $page = app(GetGameModesMinesViewAction::class)->run();

        return response()->json([
            'status' => 'success',
            'page' => $page
        ]);
    }
}
