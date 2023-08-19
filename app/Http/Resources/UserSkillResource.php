<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserSkillResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        $data = [
            'id' => $this->id == null ? "" : $this->id,
            'user_id' => $this->user_id == null ? "" : $this->user_id,
            // 'skills' => new  SkillResource($this->skill),
            'name' => $this->name == null ? "" : $this->name,

        ];

        return $data;
    }
}
