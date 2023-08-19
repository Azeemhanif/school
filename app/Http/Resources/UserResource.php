<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'email' => $this->email == null ? "" : $this->email,
            'username' => $this->username == null ? "" : $this->username,
            'avatar' => $this->avatar == null ? "" : $this->avatar,
            'is_profile_setup' => $this->is_profile_setup == 0 ? "N" : "Y",
            'is_favourite' => $this->is_favourite == 0 ? "N" : "Y",
            'description' => $this->about_me == null ? "" : $this->about_me,
            'whatsapp' => $this->whatsapp_link == null ? "" : $this->whatsapp_link,
            'skype' => $this->skype_link == null ? "" : $this->skype_link,
            'instagram' => $this->instagram_link == null ? "" : $this->instagram_link,
            'telegram' => $this->telegram_link == null ? "" : $this->telegram_link,
            'twitter' => $this->twitter_link == null ? "" : $this->twitter_link,
            'facebook' => $this->facebook_link == null ? "" : $this->facebook_link,
            'website' => $this->website_link == null ? "" : $this->website_link,
            'linkedin' => $this->linkedin_link == null ? "" : $this->linkedin_link,
            // 'profile_image' => $this->profile_image == null ? "" : $this->profile_image,
            'is_verified' => $this->is_verified == 0 ? "N" : "Y",
            'user_skills' => UserSkillResource::collection($this->userskill),
            'user_verticals' => UserVerticalResource::collection($this->uservertical),

        ];

        return $data;
    }
}
