<?php

namespace App\Containers\LiveDrops\UI\API\Resources;

use App\Containers\Item\UI\API\Resources\ItemResource;
use App\Containers\Player\UI\API\Resources\SafePlayerResource;
use Illuminate\Http\Resources\Json\JsonResource;

class LiveDropResource extends JsonResource
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
            'timestamp' => \Carbon\Carbon::now()->timestamp,
            'type' => $this->type,
            'player' => new SafePlayerResource($this->player),
            'item' => new ItemResource($this->item),
        ];
    }
}
