<?php

namespace App\Containers\BoxUnique\Models;

use App\Containers\Condition\Models\Condition;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Box extends Model
{
    use HasFactory;

    protected $with = [
        'condition'
    ];

    public function scopePromocodable($query)
    {
        return $query->whereType('promocodable');
    }

    public function scopeTimerable($query)
    {
        return $query->whereType('timerable');
    }

    public function condition()
    {
        return $this->morphOne(Condition::class, 'conditionable');
    }
}
