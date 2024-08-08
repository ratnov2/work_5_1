<?php

namespace App\Containers\Contest\UI\API\Resources;

use App\Containers\Item\UI\API\Resources\ItemResource;
use Illuminate\Http\Resources\Json\JsonResource;

class HistoryContestResource extends JsonResource
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
            'end_at' => $this->end_at,
            'count_players' => $this->players->count(),
            'win_player' => new WinPlayerResource($this->win_player),
            'item' => new ItemResource($this->item),
        ];
    }
}
