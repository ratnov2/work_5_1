<?php

namespace App\Containers\BoxUnique\UI\API\Resources;

use App\Containers\Condition\UI\API\Resources\ConditionResource;
use Illuminate\Http\Resources\Json\JsonResource;

class BoxPromocodableResource extends JsonResource
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
            'condition' =>  new ConditionResource($this->condition),
        ];
    }
}
