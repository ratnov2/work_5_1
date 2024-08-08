<?php

namespace App\Containers\SiteQuest\UI\API\Controllers;

use App\Containers\SiteQuest\Actions\CheckInStartSiteQuestAction;
use App\Containers\SiteQuest\Actions\CheckInWorkingSiteQuestAction;
use App\Containers\SiteQuest\UI\API\Resources\PlayerSiteQuestResource;
use App\Containers\SiteQuest\Actions\TakeSiteQuestAction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SiteQuestController extends Controller
{
    public function takeQuest(Request $request)
    {
        $player_site_quest = app(TakeSiteQuestAction::class)->run($request->all());

        return response()->json([
            'status' => 'success',
            'msg' => 'Вы успешно приняли задание',
            'player_site_quest' => (new PlayerSiteQuestResource($player_site_quest)),
        ]);
    }

    public function checkInStartSiteQuest(Request $request)
    {
        $player_site_quest = app(CheckInStartSiteQuestAction::class)->run($request->all());

        return response()->json([
            'status' => 'success',
            'msg' => 'Вы успешно приняли задание',
            'player_site_quest' => (new PlayerSiteQuestResource($player_site_quest)),
        ]);
    }

    public function checkInWorkingSiteQuest(Request $request)
    {
        $player_site_quest = app(CheckInWorkingSiteQuestAction::class)->run($request->all());

        return response()->json([
            'status' => 'success',
            'msg' => 'Вы успешно приняли задание',
            'player_site_quest' => (new PlayerSiteQuestResource($player_site_quest)),
        ]);
    }
}
