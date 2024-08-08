<?php

namespace App\Containers\Shop\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShopPurchace extends Model
{
    use HasFactory;

    protected $fillable = [
        'player_id', 'market_hash_names', 'price'
    ];
}
