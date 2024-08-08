<?php

namespace App\Containers\Player\Models;

use Illuminate\Database\Eloquent\Model;

class PlayerTelegramAccount extends Model
{
    protected $table = 'player_telegram_accounts';

    protected $fillable = [
        'telegram_id', 'name', 'username', 'player_id'
    ];

    public function player()
    {
        return $this->belongsTo(Player::class);
    }
}
