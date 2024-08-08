<?php

namespace App\Containers\SiteQuest\Actions;

use App\Containers\Player\Tasks\GetAuthPlayerTask;
use App\Containers\SiteQuest\Exceptions\API\SiteQuestException;
use App\Containers\SiteQuest\Models\PlayerSiteQuest;
use App\Containers\SiteQuest\Tasks\GetSiteQuestByIdTask;

final class TakeSiteQuestAction
{
    public function run($params)
    {
        $player = app(GetAuthPlayerTask::class)->run(is_locked: false, with: ['site_quests']);
        $site_quest = app(GetSiteQuestByIdTask::class)->run($params['site_quest_id']);

        if (!$site_quest) throw new SiteQuestException('Квест не найден');
        if (!$site_quest->is_active) throw new SiteQuestException('Этот квест в данный момент недоступен');
        if (!is_null($site_quest->end_at)) if (\Carbon\Carbon::parse($site_quest->end_at) <= \Carbon\Carbon::now()) throw new SiteQuestException('Этот квест более недоступен');
        if ($player->site_quests->contains($site_quest)) {
            if(!$site_quest->is_reusable) throw new SiteQuestException('Этот квест не является многоразовым');
            if($player->site_quests->first(fn($sq) => $sq->id == $site_quest->id)->pivot->status != PlayerSiteQuest::DONE) throw new SiteQuestException('Вы уже выполняете это задание');

            $player->site_quests()->updateExistingPivot($site_quest, [
                'wait_work_comment' => null,
                'wait_done_comment' => null,
                'wait_work_answer' => json_encode(['text' => $params['text'] ?? null, 'images' => $params['images'] ?? null]),
                'wait_done_answer' => null,
                'status' => $site_quest->is_wait_work_answer_required ? PlayerSiteQuest::WAIT_WORK : PlayerSiteQuest::IN_WORKING, 
            ]);
        } else {
            $player->site_quests()->attach($site_quest, [
                'status' => $site_quest->is_wait_work_answer_required ? PlayerSiteQuest::WAIT_WORK : PlayerSiteQuest::IN_WORKING, 
                'wait_work_answer' => $site_quest->is_wait_work_answer_required ? json_encode(['text' => $params['text'],'images' => $params['images']]) : null
            ]);
        }

        return $player->site_quests()->where('site_quests.id', $site_quest->id)->first();
    }
}
