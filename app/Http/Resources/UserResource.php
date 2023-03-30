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
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'email' => $this->email,
            'user_name' => $this->user_name,
            'full_name' => $this->userProfile->full_name,
            "about" => $this->userProfile->about,
            "mobile_phone" => $this->userProfile->mobile_phone,
            "theme_color" => $this->userProfile->theme_color,
            'image' => $this->userProfile->getFirstMediaUrl('userImages'),
            'interestings' => InterestingResource::collection($this->userProfile->interestings),
        ];
    }
}
