<?php

namespace App\Containers\Jackpot\Models;

use App\Containers\Item\Models\Item;
use App\Containers\Player\Models\Player;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JackpotBet extends Model
{
    use HasFactory;

    const TICKET_COST = 0.01;
    const MIN_ITEMS_PLAYER_PRICE = 0.60;

    public function jackpot()
    {
        return $this->belongsTo(Jackpot::class);
    }

    public function player()
    {
        return $this->belongsTo(Player::class);
    }

    public function items()
    {
        return $this->belongsToMany(Item::class, 'jackpot_bet_items', 'jackpot_bet_id', 'market_hash_name', 'id', 'market_hash_name')->withPivot(['market_hash_name', 'price']);
    }

    protected $fillable = [
        'player_id', 'jackpot_id', 'tickets_from', 'tickets_to', 'is_win'
    ];

    protected $hidden = [
        'is_win'
    ];

    protected $casts = [
        'is_win' => 'boolean'
    ];

    protected $with = [
        'items', 'player'
    ];
}
