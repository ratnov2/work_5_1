<?php

namespace App\Containers\Settings\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SettingsSite extends Model
{
    use HasFactory;

    protected $table = 'settings_site';

    protected $fillable = [
        'title',
        'logo',
        'favicon',
        'youtube_link',
        'telegram_link',
        'vk_link',
        'footer',
        'keywords',
        'yandex_metrika',
        'yandex_metrika_informer',
    ];
}
