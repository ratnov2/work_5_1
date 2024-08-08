<?php

namespace App\DTO;

class DTO {
    public function toArray()
    {
        return get_object_vars($this);
    }

    public function fromArray($data)
    {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        }

        return $this;
    }

    public function fromRequest($request)
    {
        $validated = $request->validated();

        return $this->fromArray($validated);
    }

    public function toJson()
    {
        return json_encode($this->toArray());
    }
}
