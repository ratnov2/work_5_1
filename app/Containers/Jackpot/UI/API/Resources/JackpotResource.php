<?php

namespace App\Containers\Jackpot\UI\API\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class JackpotResource extends JsonResource
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
            'status' => $this->status,
            'win_ticket' => $this->win_ticket,
            'bets' => JackpotBetResource::collection($this->bets)
        ];
    }
}
