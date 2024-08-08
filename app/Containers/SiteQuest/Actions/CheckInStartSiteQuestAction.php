<?php

namespace App\Containers\SiteQuest\Actions;

use App\Containers\Player\Tasks\GetAuthPlayerTask;
use App\Containers\SiteQuest\Exceptions\API\SiteQuestException;
use App\Containers\SiteQuest\Models\PlayerSiteQuest;
use App\Containers\SiteQuest\Tasks\GetSiteQuestByIdTask;

final class CheckInStartSiteQuestAction
{
    public function run($params)
    {
        if(!isset($params['text'])) throw new SiteQuestException('Поле текст обязательно для заполнения');
        if(!isset($params['images'])) throw new SiteQuestException('Скриншоты обязательны для заполнения');

        $player = app(GetAuthPlayerTask::class)->run(is_locked: false, with:['site_quests']);
        $site_quest = app(GetSiteQuestByIdTask::class)->run($params['site_quest_id']);

        if (!$site_quest) throw new SiteQuestException('Квест не найден');
        if (!is_null($site_quest->end_at)) if (\Carbon\Carbon::parse($site_quest->end_at) <= \Carbon\Carbon::now()) throw new SiteQuestException('Этот квест более недоступен');
        if (!$site_quest->is_active) throw new SiteQuestException('Этот квест в данный момент недоступен');
    
        $player->site_quests()->updateExistingPivot($site_quest->id, [
            'status' => PlayerSiteQuest::WAIT_WORK,
            'wait_work_answer' => json_encode(['text' => $params['text'] ?? null, 'images' => $params['images'] ?? null]),
        ]);

        return $player->site_quests()->where('site_quests.id', $site_quest->id)->first();
    }
}
