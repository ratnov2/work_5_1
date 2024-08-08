<?php

namespace App\Containers\Upgrade\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Upgrade extends Model
{
    use HasFactory;

    protected $fillable = [
        'player_id', 'chance', 'result', 'profit', 'wanted_market_hash_name', 'item_player_id'
    ];
}
