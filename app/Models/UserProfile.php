<?php

namespace App\Models;

use App\Enums\ColorThemeEnum;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class UserProfile extends Model implements HasMedia
{
    use HasFactory, HasUuids,InteractsWithMedia, HasUuids;

    public $timestamps = false;
    protected $with = ['interestings'];
    protected $fillable = [
        "first_name",
        "last_name",
        "about",
        "mobile_phone",
        "theme_color",
    ];

    protected $casts = [
        "theme_color" => ColorThemeEnum::class
    ];

    public function user(): belongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function fullName(): Attribute
    {
        return Attribute::make(get: fn() => $this->first_name . ' ' . $this->last_name);
    }

    public function interestings(): MorphToMany
    {
        return $this->morphToMany(Interesting::class, 'interestingable');
    }
}
