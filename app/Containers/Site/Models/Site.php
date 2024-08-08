<?php

namespace App\Containers\Site\Models;

use App\Containers\SiteQuest\Models\SiteQuest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class Site extends Model
{
    use HasFactory, AsSource;

    protected $table = 'sites';

    protected $with = [
        'quests',
    ];

    protected $casts = [
        'show' => 'boolean',
        'new' => 'boolean',
        'hot' => 'boolean',
        'vpn' => 'boolean'
    ];

    protected $fillable = [
        'position', 
        'price', 
        'link', 
        'image', 
        'promo', 
        'category_id',  
        'show', 
        'new', 
        'hot', 
        'vpn'
    ];

    public function category()
    {
        return $this->belongsTo(SiteCategory::class, 'category_id');
    }

    public function quests()
    {
        return $this->hasMany(SiteQuest::class, 'site_id', 'id')->active();
    }

    public function scopeActive($q)
    {
        return $q->where('show', true);
    }
}
