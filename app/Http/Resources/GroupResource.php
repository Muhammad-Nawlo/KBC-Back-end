<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GroupResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "title" => $this->title,
            "group_name" => $this->group_name,
            'image' => $this->getFirstMediaUrl('groupImages'),
            'about' => $this->about,
            'max_member' => $this->max_member,
            'interesting' => InterestingResource::collection($this->whenLoaded('interestings')),
            'users' => $this->whenLoaded('users'),
            'group_type' => $this->groupType,
            'user_can_join_directly' => $this->user_can_join_directly,
        ];
    }
}
