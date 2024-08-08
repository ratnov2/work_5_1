<?php

namespace App\Containers\Mines\Models;

use App\Containers\Mines\Data\Types\Status;
use App\Containers\Player\Models\Player;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MinesGame extends Model
{
    use HasFactory;

    protected $fillable = [
        'player_id',
        'cell_results',
        'count_mines',
        'win_amount',
        'balance',
        'market_hash_name',
        'status',
    ];

    protected $casts = [
        'cell_results' => 'array',
        'status' => Status::class,
    ];

    public function player()
    {
        return $this->belongsTo(Player::class);
    }

    public function item()
    {
        return $this->belongsTo(Player::class);
    }

    public function bets()
    {
        return $this->hasMany(MinesGameBet::class);
    }

    public function scopeInGame($query)
    {
        return $query->where('status', Status::IN_GAME);
    }
}
