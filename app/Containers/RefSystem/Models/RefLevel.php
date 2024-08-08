<?php

namespace App\Containers\RefSystem\Models;

use App\Containers\Player\Models\Player;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class RefLevel extends Model
{
    use HasFactory, AsSource;

    protected $fillable = [
        'sum_payments',
        'level',
        'bonus_precent',
        'ref_bonus_precent',
        'type',
        'name',
    ];

    public function players()
    {
        return $this->hasMany(Player::class);
    }

    public function getFullAttribute(): string
    {
        switch ($this->attributes['type']) {
            case 'standart':
                return 'Стандарт | LVL: ' . $this->attributes['level'] . ' | Бонус: ' . $this->attributes['bonus_precent'] . ' %' . ' | Реф. бонус: ' . $this->attributes['ref_bonus_precent'] . ' %';
            case 'custom':
                return $this->attributes['name'] . ' | Бонус: ' . $this->attributes['bonus_precent'] . ' %' . ' | Реф. бонус: ' . $this->attributes['ref_bonus_precent'] . ' %';
            default:
                return 'Неопределен тип уровня';
        }
    }

    public function scopeStandart($query)
    {
        return $query->where('type', 'standart');
    }

    public function scopeCustom($query)
    {
        return $query->where('type', 'custom');
    }

    public function scopeStart($query)
    {
        return $query->where('level', 1);
    }
}
