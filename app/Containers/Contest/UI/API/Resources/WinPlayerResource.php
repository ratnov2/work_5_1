<?php

namespace App\Containers\Contest\UI\API\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class WinPlayerResource extends JsonResource
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
        ];
    }
}
