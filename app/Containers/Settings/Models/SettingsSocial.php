<?php

namespace App\Containers\Settings\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SettingsSocial extends Model
{
    use HasFactory;
       
    protected $casts = [
        'VKONTAKTE_CLIENT_SECRET' => 'encrypted',
        'TELEGRAM_TOKEN' => 'encrypted',
    ];

    protected $fillable = [
        'VKONTAKTE_CLIENT_ID', 
        'VKONTAKTE_CLIENT_SECRET',
        'TELEGRAM_BOT_NAME',
        'TELEGRAM_TOKEN',
    ];
}
