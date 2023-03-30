<?php

namespace App\Events;

use App\Models\Group;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewMessage implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public Group $group, public string $message)
    {

    }

    public function broadcastAs()
    {
        return 'newMessage';
    }

    public function broadcastWith()
    {
        return [
            'message' => $this->message
        ];
    }

    public function broadcastOn(): array
    {
        return [
            new PresenceChannel('group.' . $this->group->id),
        ];
    }


}
