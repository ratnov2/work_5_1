<?php

namespace App\Containers\Settings\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SettingsApiKey extends Model
{
    use HasFactory;
       
    protected $casts = [
        'MARKET_API_KEY' => 'encrypted', 
        'STEAM_API_KEY' => 'encrypted',
    ];

    protected $fillable = [
        'MARKET_API_KEY', 
        'STEAM_API_KEY'
    ];
}
