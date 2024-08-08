<?php

namespace App\Containers\BoxMoney\UI\API\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BoxMoneyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $to_bank = $this->price * (100 - $this->profit_precent) / 100;
        return [
            'id' => $this->id,
            'name' => $this->name,
            'image' => $this->image,
            'price' => $this->price,
            'min_item_price' => round($to_bank * 0.6, 2),
            'max_item_price' => round($this->price * 20, 2),
        ];
    }
}
