<?php

namespace App\Models;

use Cog\Contracts\Love\Reactable\Models\Reactable as IReactable;
use Cog\Laravel\Love\Reactable\Models\Traits\Reactable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Message extends Model implements IReactable
{
    use HasFactory, Reactable, HasUuids;

    protected $fillable = [
        'conversation_id',
        'body',
        'seen',
        'is_pin',
        'is_visible',
        'reply_message_id',
    ];


    public function reports():MorphMany
    {
        return $this->morphMany(Report::class, 'reportable');
    }

    public function replyMessages(): HasMany
    {
        return $this->hasMany(Message::class, 'reply_message_id', 'id');
    }

    public function attachments():MorphMany
    {
        return $this->morphMany(Attachment::class, 'attachmentable');
    }
}
