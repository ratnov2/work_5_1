<?php

namespace App\Containers\AllNotification\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;
use Illuminate\Database\Eloquent\SoftDeletes;

class AllNotification extends Model
{
    use HasFactory, AsSource, Filterable, SoftDeletes;

    protected $with = [];

    protected $fillable = [
        'data',
    ];

    protected $casts = [];
}
