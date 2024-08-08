<?php

namespace App\Containers\SiteQuest\Models;

use App\Containers\Player\Models\Player;
use App\Containers\SiteQuest\Models\SiteQuest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class PlayerSiteQuest extends Model
{
    use HasFactory, AsSource, Filterable;

    const IN_START = 'in_start';
    const WAIT_WORK = 'wait_work';
    const IN_WORKING = 'in_working';
    const WAIT_DONE = 'wait_done';
    const DONE = 'done';

    protected $table = 'player_site_quest';

    protected $casts = [
        'wait_work_answer' => 'array',
        'wait_done_answer' => 'array',
    ];

    protected $with = [
        'player',
        'site_quest',
        'rewards'
    ];

    protected $fillable = [
        'player_id',
        'site_quest_id',
        'wait_work_comment',
        'wait_done_comment',
        'wait_work_answer',
        'wait_done_answer',
        'status',
    ];

    protected $allowedFilters = [
        'status',
    ];

    public function player()
    {
        return $this->belongsTo(Player::class);
    }

    public function site_quest()
    {
        return $this->belongsTo(SiteQuest::class);
    }

    public function rewards()
    {
        return $this->hasMany(PlayerSiteQuestReward::class);
    }

    public function scopeWait($query)
    {
        return $query->whereIn('status', [self::WAIT_WORK, self::WAIT_DONE]);
    }
}
