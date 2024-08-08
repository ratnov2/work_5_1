<?php

namespace App\Containers\SiteQuest\UI\API\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SiteQuestResource extends JsonResource
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
            'description' => $this->description, 
            'reward_price' => $this->reward_price, 
            'end_at' => $this->end_at,
            'is_wait_work_answer_required' => $this->is_wait_work_answer_required,
            'is_wait_done_answer_required' => $this->is_wait_done_answer_required,
            'is_reusable' => $this->is_reusable,
        ];
    }
}
