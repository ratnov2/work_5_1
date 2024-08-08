<?php

namespace App\Containers\PaymentSection\PaymentSystem\UI\API\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PaymentSystemDirectionResource extends JsonResource
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
            'category_slugs' => $this->categories->pluck('slug')->toArray(),
            'is_active' => $this->is_active,
            'is_need_sum' => $this->is_need_sum,
        ];
    }
}
