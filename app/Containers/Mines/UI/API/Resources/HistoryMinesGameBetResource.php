<?php

namespace App\Containers\Mines\UI\API\Resources;

use App\Containers\Item\UI\API\Resources\ItemResource;
use Illuminate\Http\Resources\Json\JsonResource;

class HistoryMinesGameBetResource extends JsonResource
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
            'price' => round($this->playerItem->price, 2),
            'item' => new ItemResource($this->playerItem->item),
        ];
    }
}
