<?php

namespace App\Containers\BoxLimit\Models;

use App\Containers\Condition\Models\Condition;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class BoxLimit extends Model
{
    use HasFactory, AsSource, Filterable, SoftDeletes;

    protected $table = 'boxes_limit';

    protected $allowedSorts = [
        'position',
    ];

    protected $fillable = [
        'name', 'image', 'max_item_price', 'limit', 'limit_left', 'hue_rotate', 'position'
    ];

    public function condition()
    {
        return $this->morphOne(Condition::class, 'conditionable');
    }

    public function scopeActive($query)
    {
        return $query->where('limit_left', '>', 0)->orderBy('position');
    }
}
