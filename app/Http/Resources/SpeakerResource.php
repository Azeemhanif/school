<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SpeakerResource extends JsonResource
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
            'name' => $this->name == null ? "" : $this->name,
            'company' => $this->company == null ? "" : $this->company,
            'companyposition' => $this->companyposition == null ? "" : $this->companyposition,
            'website' => $this->website == null ? "" : $this->website,
            'linkedin' => $this->linkedin == null ? "" : $this->linkedin,
            'instagram' => $this->instagram == null ? "" : $this->instagram,
            'twitter' => $this->twitter == null ? "" : $this->twitter,
            'facebook' => $this->facebook == null ? "" : $this->facebook,
            'tiktok' => $this->tiktok == null ? "" : $this->tiktok,
            'bio' => $this->about == null ? "" : $this->about,
            'event' => $this->event == null ? "" : $this->event,
            'weight' => $this->weight == null ? "" : $this->weight,
            'imagine' => $this->imagine == null ? "" : $this->imagine,
            'datetime' => $this->datetime == null ? "" : $this->datetime,
            'public' => $this->public == null ? "" : $this->public,
        ];

        return $data;
    }
}
