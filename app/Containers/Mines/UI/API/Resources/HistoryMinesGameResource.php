<?php

namespace App\Containers\Mines\UI\API\Resources;

use App\Containers\Player\UI\API\Resources\SafePlayerResource;
use Illuminate\Http\Resources\Json\JsonResource;

class HistoryMinesGameResource extends JsonResource
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
            'count_mines' => $this->count_mines,
            'win_amount' => !is_null($this->win_amount) ? round($this->win_amount, 2) : null,
            'player' => new SafePlayerResource($this->player),
            'bets' => HistoryMinesGameBetResource::collection($this->bets),
        ];
    }
}
