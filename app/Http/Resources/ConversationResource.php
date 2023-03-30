<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ConversationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'group' => new GroupResource ($this->whenLoaded('group')),
            'group_privilege' => $this->group_privilege,
            'is_mute' => $this->is_mute,
            'is_favorite' => $this->is_favorite,
            'status' => $this->status,
            'messages' => MessageResource::collection($this->whenLoaded('messages'))
        ];
    }
}
