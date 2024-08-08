<?php

namespace App\Containers\Jackpot\UI\API\Resources;

use App\Containers\Item\UI\API\Resources\ItemResource;
use App\Containers\Player\UI\API\Resources\SafePlayerResource;
use Illuminate\Http\Resources\Json\JsonResource;

class JackpotHistoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $win_bet = $this->bets->firstWhere('is_win', true);
        $win_player = $win_bet->player()->first();
        return [
            'win_player' => new SafePlayerResource($win_player),
            'win_ticket' => $this->win_ticket,
            'win_precent' => round($win_bet->items->sum('pivot.price') * 100 / $this->bank, 2),
            'bank' => $this->bank,
            'round_id' => $this->id,
            'items' => ItemResource::collection($win_bet->items)
        ];
    }
}
