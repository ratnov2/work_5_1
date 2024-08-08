<?php

namespace App\Containers\BoxLimit\UI\API\Resources;

use App\Containers\Condition\UI\API\Resources\ConditionResource;
use Illuminate\Http\Resources\Json\JsonResource;

class BoxLimitResource extends JsonResource
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
            'name' => $this->name,
            'image' => $this->image,
            'limit' => $this->limit,
            'limit_left' => $this->limit_left,
            'hue_rotate' => $this->hue_rotate,
            'condition' =>  new ConditionResource($this->condition),
        ];
    }
}
