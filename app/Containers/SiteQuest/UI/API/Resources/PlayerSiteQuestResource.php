<?php

namespace App\Containers\SiteQuest\UI\API\Resources;

use App\Containers\SiteQuest\Models\PlayerSiteQuest;
use Illuminate\Http\Resources\Json\JsonResource;

class PlayerSiteQuestResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $player_site_quest = PlayerSiteQuest::where('id', $this->pivot->id)->first();

        return [
            'id' => $this->pivot->id,
            'site_quest' => new SiteQuestResource($this),
            'wait_work_comment' => $player_site_quest->wait_work_comment,
            'wait_done_comment' => $player_site_quest->wait_done_comment,
            'wait_work_answer' => $player_site_quest->wait_work_answer,
            'wait_done_answer' => $player_site_quest->wait_done_answer,
            'status' => $player_site_quest->status,
            'rewards' => PlayerSiteQuestRewardResource::collection($player_site_quest->rewards),
        ];
    }
}
