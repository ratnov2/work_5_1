<?php

namespace App\Containers\Settings\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SettingsPaymentSystem extends Model
{
    use HasFactory;
       
    protected $casts = [
        'ENOT_SECRET_WORD' => 'encrypted',
        'ENOT_EXTRA_SECRET_WORD' => 'encrypted',
    ];

    protected $fillable = [
        'ENOT_MERCHANT_ID', 
        'ENOT_SECRET_WORD',
        'ENOT_EXTRA_SECRET_WORD',
    ];
}
