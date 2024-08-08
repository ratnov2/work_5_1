<?php

namespace App\Containers\Banner\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;
use Jenssegers\Date\Date;

class Banner extends Model
{
    use HasFactory, AsSource;

    const TOP_TYPE = 'top';
    const LEFT_TYPE = 'left';
    const RIGHT_TYPE = 'right';

    protected $table = 'banners';

    protected $fillable = [
        'image', 'link', 'type', 'show'
    ];

    protected $casts = [
        'show' => 'boolean'
    ];

    public function getHumanCreatedAtAttribute()
    {
        return Date::parse($this->created_at)->format('l j F Y H:i:s');
    }

    public function scopeActive($query)
    {
        return $query->where('show', true);
    }

    public function scopeTop($query)
    {
        return $query->where('type', self::TOP_TYPE);
    }

    public function scopeLeft($query)
    {
        return $query->where('type', self::LEFT_TYPE);
    }

    public function scopeRight($query)
    {
        return $query->where('type', self::RIGHT_TYPE);
    }
}
