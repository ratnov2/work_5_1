<?php

namespace App\Containers\Settings\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SettingsBox extends Model
{
    use HasFactory;

    protected $table = 'settings_box';

    protected $fillable = [
        'box_timer',
        'box_promocode',
        'box_timer_max_item_price',
        'box_promocode_max_item_price',
        'box_timer_min_sum_payments_time_day'
    ];

    protected $casts = [
        'box_timer' => 'boolean',
        'box_promocode' => 'boolean',
    ];
}
