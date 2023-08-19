<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SponsorResource extends JsonResource
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
            'url' => $this->url == null ? "" : $this->url,
            'logo' => $this->logo == null ? "" : $this->logo,
            'transportation' => $this->transportation == 0 ? "Y" : "N",
            'event' => $this->event == null ? "" : $this->event,
            'event2' => $this->event2 == null ? "" : $this->event2,
            'about' => $this->description == null ? "" : $this->description,
            'issponsornow' => $this->issponsornow == 0 ? "Y" : "N",
            'orderby' => $this->orderby == 0 ? "Y" : "N",
            'ticketid' => $this->ticketid == 0 ? "Y" : "N",
            'status' => $this->status == 0 ? "Y" : "N",

        ];
    }
}
