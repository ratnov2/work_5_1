<?php

namespace App\Containers\Pages\Actions;

use App\Containers\Pages\Exceptions\API\SiteQuestViewException;
use App\Containers\Player\Tasks\GetAuthPlayerTask;
use App\Containers\Site\Tasks\GetSiteByIdTask;
use App\Containers\Site\UI\API\Resources\SiteResource;
use App\Containers\SiteQuest\UI\API\Resources\PlayerSiteQuestResource;
use Illuminate\Support\Facades\View;

final class GetSiteQuestViewAction
{
    public function run($id)
    {
        $site = app(GetSiteByIdTask::class)->run($id);
        if(!$site) throw new SiteQuestViewException('Сайт не найден');
        $site_json = (new SiteResource($site))->toJson();
        
        $player = app(GetAuthPlayerTask::class)->run(is_locked:false, with:['site_quests']);
        if($player) $player_site_quests_json = PlayerSiteQuestResource::collection($player->site_quests->filter(fn($site_quest) => $site_quest->site_id == $site->id))->toJson();
        
        return View::make("pages::pages.siteQuest.index", [
            'site' => $site,
            'site_json' => $site_json,
            'player_site_quests_json' => $player_site_quests_json ?? null,
        ])->render();
    }
}
