<?php

namespace App\Containers\GameModes\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banks extends Model
{
    use HasFactory;

    protected $table = 'game_modes_banks';

    public function scopeUpgrade($query)
    {
        return $query->where('game_mode', 'upgrade');
    }

    public function scopeBoxesMoney($query)
    {
        return $query->where('game_mode', 'boxes_money');
    }

    public function scopeMines($query)
    {
        return $query->where('game_mode', 'mines');
    }
}
