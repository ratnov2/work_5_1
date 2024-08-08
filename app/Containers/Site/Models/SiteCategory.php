<?php

namespace App\Containers\Site\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;
use Jenssegers\Date\Date;

class SiteCategory extends Model
{
    use HasFactory, AsSource;

    protected $table = 'site_categories';

    protected $fillable = [
        'position', 'name'
    ];

    protected $with = [
        'sites'
    ];

    public function sites()
    {
        return $this->hasMany(Site::class, 'category_id')->active()->orderBy('position');
    }

    public function getHumanCreatedAtAttribute()
    {
        return Date::parse($this->created_at)->format('l j F Y H:i:s');
    }

    public function scopeActive($query)
    {
        return $query->whereHas('sites', fn($site) => $site->active());
    }
}
