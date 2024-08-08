<?php

namespace App\Containers\Player\UI\API\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PlayerItemResource extends JsonResource
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
            'updated_at' => $this->updated_at->getPreciseTimestamp(3),
            'uniqid' => $this->uniqid,
            'status' => $this->status,
            'price' => round($this->price, 2),

            'market_hash_name' => $this->item->market_hash_name,
            'quality' => $this->item->quality,
            'rarity' => $this->item->rarity,
        ];
    }
}
