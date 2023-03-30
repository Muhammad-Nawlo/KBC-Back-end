<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Group extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, SoftDeletes, HasUuids;

    protected $with = ['groupType'];
    public $fillable = [
        "title",
        "group_name",
        'about',
        'status',
        'max_member',
        'group_type_id',
        'user_can_join_directly',
    ];

    public function interestings()
    {
        return $this->morphToMany(Interesting::class, 'interestingable');
    }

    public function groupType(): BelongsTo
    {
        return $this->belongsTo(GroupType::class);
    }


    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'conversations')->withTimestamps();
    }

    public function reports(): MorphMany
    {
        return $this->morphMany(Report::class, 'reportable');
    }

    public function scopeRelated(Builder $query, array $interesting = [])
    {
        $query->when($interesting ?? false,
            fn($query, $interest) => $query->whereHas('interestings', fn($query) => $query->whereIn('id', $interest))
        );
    }




}
