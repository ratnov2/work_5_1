<?php

namespace App\Containers\SiteQuest\UI\API\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PlayerSiteQuestRewardResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'value' => $this->value
        ];
    }
}
