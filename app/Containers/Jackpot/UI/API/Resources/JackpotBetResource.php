<?php

namespace App\Containers\Jackpot\UI\API\Resources;

use App\Containers\Player\UI\API\Resources\SafePlayerResource;
use Illuminate\Http\Resources\Json\JsonResource;

class JackpotBetResource extends JsonResource
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
            'player' => new SafePlayerResource($this->player),
            'sum' => round($this->items->sum('pivot.price'), 2),
            'tickets_from' => $this->tickets_from,
            'tickets_to' => $this->tickets_to,
            'items' => JackpotBetItemResource::collection($this->items),
            'timestamp' => $this->created_at->getPreciseTimestamp(3)
        ];
    }
}
