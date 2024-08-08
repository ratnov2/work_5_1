<?php

namespace App\Containers\Jackpot\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JackpotBetItem extends Model
{
    use HasFactory;

    public $table = 'jackpot_bet_items';

    public function bet()
    {
        return $this->belongsTo(JackpotBet::class);
    }

}
