<?php

namespace App\Containers\RefSystem\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefReward extends Model
{
    use HasFactory;

    protected $fillable = [
        'payment_id', 'referrer_id', 'referral_id', 'reward'
    ];
}
