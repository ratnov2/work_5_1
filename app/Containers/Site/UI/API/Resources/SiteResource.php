<?php

namespace App\Containers\Site\UI\API\Resources;

use App\Containers\SiteQuest\UI\API\Resources\SiteQuestResource;
use Illuminate\Http\Resources\Json\JsonResource;

class SiteResource extends JsonResource
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
            'position' => $this->position,
            'price' => $this->price,
            'image' => $this->image,
            'promo' => $this->promo,
            'link' => $this->link,
            'show' => $this->show,
            'new' => $this->new,
            'hot' => $this->hot,
            'vpn' => $this->vpn,
            'quests' => SiteQuestResource::collection($this->quests),
        ];
    }
}
