<?php

namespace App\Containers\Contest\UI\API\Resources;

use App\Containers\Condition\UI\API\Resources\ConditionResource;
use App\Containers\Item\UI\API\Resources\ItemResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ContestResource extends JsonResource
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
            'type' => $this->type,
            'reserved_at' => $this->reserved_at,
            'end_at' => $this->end_at,
            'count_players' => $this->players->count(),
            'condition' =>  new ConditionResource($this->condition),
            'item' => new ItemResource($this->item),
        ];
    }
}
