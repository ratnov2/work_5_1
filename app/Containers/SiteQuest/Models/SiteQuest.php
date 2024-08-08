<?php

namespace App\Containers\SiteQuest\Models;

use App\Containers\Site\Models\Site;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Orchid\Screen\AsSource;

class SiteQuest extends Model
{
    use HasFactory, AsSource, SoftDeletes;

    protected $table = 'site_quests';

    protected $casts = [
        'is_active' => 'boolean',
        'is_wait_work_answer_required' => 'boolean',
        'is_wait_done_answer_required' => 'boolean',
        'is_reusable' => 'boolean',
    ];

    protected $fillable = [
        'site_id', 
        'name', 
        'description', 
        'reward_price', 
        'end_at', 
        'is_wait_work_answer_required',
        'is_wait_done_answer_required',
        'is_reusable', 
        'is_active', 
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function site()
    {
        return $this->belongsTo(Site::class);
    }
}
