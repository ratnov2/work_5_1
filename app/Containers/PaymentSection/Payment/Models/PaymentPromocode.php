<?php

namespace App\Containers\PaymentSection\Payment\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Jenssegers\Date\Date;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class PaymentPromocode extends Model
{
    use HasFactory, AsSource, Filterable, SoftDeletes;

    protected $fillable = [
        'value', 'precent'
    ];

    public function getHumanCreatedAtAttribute()
    {
        return Date::parse($this->created_at)->format('l j F Y H:i:s');
    }

    public function getHumanUpdatedAtAttribute()
    {
        return Date::parse($this->updated_at)->format('l j F Y H:i:s');
    }
}
