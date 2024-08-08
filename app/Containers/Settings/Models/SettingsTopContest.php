<?php

namespace App\Containers\Settings\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SettingsTopContest extends Model
{
    use HasFactory;

    protected $table = 'settings_top_contest';

    protected $fillable = [
        'first_place_sum', 'second_place_sum', 'third_place_sum', 'every_hours'
    ];
}
