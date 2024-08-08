<?php

namespace App\Containers\Jackpot\UI\API\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class JackpotBetItemResource extends JsonResource
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
            'id' => $this->pivot->id,

            'market_hash_name' => $this->market_hash_name,
            'quality' => $this->quality,
            'rarity' => $this->rarity,
        ];
    }
}
