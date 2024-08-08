<?php

namespace App\Containers\Mines\Models;

use App\Containers\Player\Models\PlayerItem;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MinesGameBet extends Model
{
    use HasFactory;

    protected $fillable = [
        'mines_game_id',
        'item_player_id',
    ];

    protected $with = [
        'playerItem'
    ];

    public function playerItem()
    {
        return $this->belongsTo(PlayerItem::class, 'item_player_id', 'id');
    }
}
