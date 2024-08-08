<?php

namespace App\Containers\RefSystem\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class RefBalanceWithdraw extends Model
{
    use HasFactory, AsSource;

    public const STATUS_WAIT = 0;
    public const STATUS_SUCCESS = 1;

    protected $fillable = [
        'sum',
        'referrer_id',
        'status'
    ];
}
