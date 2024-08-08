<?php

namespace App\Containers\SiteQuest\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlayerSiteQuestReward extends Model
{
    use HasFactory;

    protected $table = 'player_site_quest_rewards';

    protected $fillable = [
        'player_site_quest_id',
        'value',
    ];
}
