<?php

namespace App\Containers\Item\UI\API\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ItemResource extends JsonResource
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
            'market_hash_name' => $this->market_hash_name,
            'ru_market_hash_name' => $this->ru_market_hash_name,
            'price' => round($this->price, 2),
            'quantity' => $this->quantity,
            'quality' => $this->quality,
            'rarity' => $this->rarity,
        ];
    }
}
