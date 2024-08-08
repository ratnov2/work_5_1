<?php

namespace App\Containers\Player\UI\API\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SafePlayerResource extends JsonResource
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
            'steam_id' => $this->steam_id,
            'image' => $this->image,
            'ref_level' => [
                'level' => $this->ref_level->level,
                'name' => $this->ref_level->name,
            ],
            'roles' => PlayerRoleResource::collection($this->roles),
        ];
    }
}
