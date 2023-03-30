<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Cog\Contracts\Love\Reacterable\Models\Reacterable as IReacterable;
use Fico7489\Laravel\Pivot\Traits\PivotEventTrait;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Cog\Laravel\Love\Reacterable\Models\Traits\Reacterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements IReacterable, MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, HasUuids, SoftDeletes, Reacterable;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'password',
        'status',
        'user_name',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function userProfile(): hasOne
    {
        return $this->hasOne(UserProfile::class);
    }

    //get reports that belong to a user
    public function reports(): MorphMany
    {
        return $this->morphMany(Report::class, 'reportable');
    }

    //get reports that a user make
    public function reporting(): HasMany
    {
        return $this->hasMany(Report::class);
    }

    public function groups(): BelongsToMany
    {
        return $this->belongsToMany(Group::class, 'conversations')->withPivot(['*'])->withTimestamps();
    }

    public function conversations(): HasMany
    {
        return $this->hasMany(Conversation::class);
    }

    public function canJoinGroup($groupId): bool
    {
        return $this->groups()->where('id', $groupId)->first() !== null;
    }
}
