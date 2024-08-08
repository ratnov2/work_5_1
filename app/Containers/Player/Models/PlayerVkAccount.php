<?php

namespace App\Containers\Player\Models;

use Illuminate\Database\Eloquent\Model;

class PlayerVkAccount extends Model
{
    protected $table = 'player_vk_accounts';

    protected $fillable = [
        'vk_id', 'name', 'image', 'access_token', 'player_id'
    ];

    public function player()
    {
        return $this->belongsTo(Player::class);
    }
}
