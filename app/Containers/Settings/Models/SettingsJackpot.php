<?php

namespace App\Containers\Settings\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SettingsJackpot extends Model
{
    use HasFactory;

    protected $table = 'settings_jackpot';

    protected $fillable = [
        'profit_precent', 'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];
}
