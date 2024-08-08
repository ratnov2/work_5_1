<?php

namespace App\Containers\Site\UI\API\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SiteCategoryResource extends JsonResource
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
            'sites' => SiteResource::collection($this->sites),
        ];
    }
}
