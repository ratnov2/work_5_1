<?php

namespace App\Containers\Item\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Item extends Model
{
    use HasFactory, Filterable, AsSource;

    protected $hidden = [
        'is_updatable'
    ];

    protected $allowedFilters = [
        'market_hash_name'
    ];

    protected $casts = [
        'is_updatable' => 'boolean'
    ];

    protected $fillable = [
        'market_hash_name',
        'ru_market_hash_name',
        'price',
        'price_market',
        'quantity',
        'quality',
        'rarity',
        'class_instance',
    ];
}
