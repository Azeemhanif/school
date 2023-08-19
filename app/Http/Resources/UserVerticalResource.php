<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserVerticalResource extends JsonResource
{

    public function toArray($request)
    {
        $data = [
            'id' => $this->id == null ? "" : $this->id,
            'user_id' => $this->user_id == null ? "" : $this->user_id,
            // 'verticals' => new VerticalResource($this->vertical),
            'name' => $this->name == null ? "" : $this->name,
        ];

        return $data;
    }
}
