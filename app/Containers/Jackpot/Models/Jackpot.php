<?php

namespace App\Containers\Jackpot\Models;

use App\Containers\Jackpot\Data\Types\Status;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jackpot extends Model
{
    use HasFactory;

    protected $fillable = [
        'win_ticket', 'profit', 'status', 'bank', 'win_item_price', 'win_balance'
    ];

    protected $with = [
        'bets'
    ];

    protected $casts = [
        'status' => Status::class,
    ];

    public function scopeAccessBetting($query)
    {
        return $query->where('status', Status::Wait)->orWhere('status', Status::WaitTimeout);
    }

    public function scopeWait($query)
    {
        return $query->where('status', Status::Wait);
    }

    public function scopeWaitTimeout($query)
    {
        return $query->where('status', Status::WaitTimeout);
    }

    public function scopeActive($query)
    {
        return $query->where('status', Status::Active);
    }

    public function scopeEnd($query)
    {
        return $query->where('status', Status::End);
    }

    public function bets()
    {
        return $this->hasMany(JackpotBet::class)->orderBy('id', 'desc');
    }
}
