<?php

namespace App\Containers\Condition\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Condition extends Model
{
    use HasFactory, AsSource, Filterable;

    protected $fillable = [
        'action', 'conditionable_id', 'conditionable_type'
    ];

    public function conditionable()
    {
        return $this->morphTo();
    }
}
