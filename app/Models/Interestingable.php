<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Interestingable extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'interesting_id',
        'interestingable_id',
        'interestingable_type'
    ];
}
