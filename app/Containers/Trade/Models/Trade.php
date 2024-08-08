<?php

namespace App\Containers\Trade\Models;

use App\Containers\Item\Models\Item;
use App\Containers\Player\Models\Player;
use App\Containers\Trade\Data\Types\Status;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Trade extends Model
{
    use HasFactory;

    protected $table = 'trades';

    protected $fillable = [
        'item_player_id',
        'market_hash_name',
        'price',
        'custom_id',
        'paid',
        'status',
        'result'
    ];

    public function item()
    {
        return $this->belongsTo(Item::class, 'market_hash_name', 'market_hash_name');
    }

    public function player()
    {
        return $this->belongsTo(Player::class);
    }

    public function scopeSuccess($query)
    {
        return $query->where('status', Status::Success);
    }

    public function scopeProcessing($query)
    {
        return $query->where('status', Status::Proccessing)->orWhere('status', Status::ProccessingFail);
    }
}
