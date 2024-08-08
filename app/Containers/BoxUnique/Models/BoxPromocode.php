<?php

namespace App\Containers\BoxUnique\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;
use Orchid\Filters\Filterable;

class BoxPromocode extends Model
{
    use HasFactory, AsSource, Filterable;

    protected $allowedFilters = [
        'id',
        'value',
        'limit',
    ];

    protected $allowedSorts = [
        'id',
        'value',
        'limit',
    ];

    protected $fillable = [
        'limit', 'value'
    ];

    public function scopeActive($query)
    {
        return $query->whereNull('limit')->orWhere('limit', '>', 0);
    }
}
