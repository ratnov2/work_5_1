<?php

namespace App\Containers\Mines\UI\API\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PlayerMineGameResource extends JsonResource
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
            'cell_results' => (object) $this->cell_results,
            'count_mines' => $this->count_mines,
            'win_amount' => $this->win_amount,
            'balance' => $this->balance,
            'status' => $this->status,
            'bets' => PlayerMineGameBetResource::collection($this->bets)
        ];
    }
}
