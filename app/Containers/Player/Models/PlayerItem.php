<?php

namespace App\Containers\Player\Models;

use App\Containers\Item\Models\Item;
use App\Containers\Player\Data\Types\PlayerItemStatus;
use Illuminate\Database\Eloquent\Model;

class PlayerItem extends Model
{
    protected $table = 'item_player';

    protected $fillable = [
        'player_id',
        'market_hash_name',
        'dropable_type', 
        'dropable_id',
        'status',
        'price',
        'uniqid',
    ];

    public function scopeReady($query)
    {
        return $query->where('status', PlayerItemStatus::Ready);
    }

    public function scopeMinesed($query)
    {
        return $query->where('status', PlayerItemStatus::Mines);
    }

    public function player()
    {
        return $this->belongsTo(Player::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class, 'market_hash_name', 'market_hash_name');
    }
}
