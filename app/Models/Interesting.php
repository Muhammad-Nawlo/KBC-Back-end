<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Interesting extends Model
{
    use HasFactory, HasUuids;

    public function userProfiles(): MorphToMany
    {
        return $this->morphedByMany(UserProfile::class, 'interestingable');
    }

    public function groups(): MorphToMany
    {
        return $this->morphedByMany(Group::class, 'interestingable');
    }
}
