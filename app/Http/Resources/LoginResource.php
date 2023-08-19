<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LoginResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id == null ? "" : $this->id,
            'name' => $this->name == null ? "" : $this->name,
            'email' => $this->email == null ? "" : $this->email,
            'token' => $this->token == null ? "" : $this->token,
        ];
    }
}
