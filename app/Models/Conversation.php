<?php

namespace App\Models;

use App\Enums\ConversationStatusEnum;
use App\Enums\GroupPrivilegeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Conversation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'group_id',
        'group_privilege',
        'is_mute',
        'is_favorite',
        'status',
        'rate',
        'last_time_open_group',
    ];
    protected $casts = [
        'last_time_open_group' => 'datetime',
        'status' => ConversationStatusEnum::class,
        'group_privilege' => GroupPrivilegeEnum::class
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }

    public function groupPrivilege(): BelongsTo
    {
        return $this->belongsTo(GroupPrivilege::class);
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }
}
