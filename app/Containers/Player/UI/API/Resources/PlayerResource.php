<?php

namespace App\Containers\Player\UI\API\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PlayerResource extends JsonResource
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
            'name' => $this->name,
            'steam_id' => (string) $this->steam_id,
            'balance' => (float) $this->balance,
            'ref_balance' => (float) $this->ref_balance,
            'trade_link' => $this->trade_link,
            'ref_code' => $this->ref_code,
            'image' => $this->image,
            'contests_ids' => $this->contests->pluck('id')->toArray(),
            'referrer_bonus_precent' => (float) $this->referrer?->ref_level->ref_bonus_precent,
            'roles' => PlayerRoleResource::collection($this->roles),
            'telegramAccount' => $this->telegramAccount ? new PlayerTelegramAccountResource($this->telegramAccount) : null,
            'vkAccount' => $this->vkAccount ? new PlayerVkAccountResource($this->vkAccount) : null,
            'items' => []
        ];
    }
}
