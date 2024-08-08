<?php

namespace App\Containers\PaymentSection\Payment\Models;

use App\Containers\Player\Models\Player;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Date\Date;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Payment extends Model
{
    use HasFactory, SoftDeletes, AsSource, Filterable, SoftDeletes;

    public const STATUS_SUCCESS     = 1;
    public const STATUS_WAITING     = 0;
    public const STATUS_REJECTED    = 4;
    public const STATUS_EXPIRED     = 5;

    public function getHumanCreatedAtAttribute()
    {
        return Date::parse($this->created_at)->format('l j F Y H:i:s');
    }

    public function getHumanUpdatedAtAttribute()
    {
        return Date::parse($this->updated_at)->format('l j F Y H:i:s');
    }

    protected $fillable = [
        'paymentable_type', 
        'paymentable_id', 
        'sum', 
        'final_sum', 
        'promocode_id', 
        'player_id', 
        'status'
    ];

    protected $with = [
        'promocode'
    ];

    protected $allowedSorts = [
        'status',
        'sum',
        'final_sum',
    ];

    protected $allowedFilters = [
        'status',
        'sum',
        'final_sum',
    ];

    public function promocode()
    {
        return $this->belongsTo(PaymentPromocode::class);
    }

    public function paymentable()
    {
        return $this->morphTo();
    }

    public function player()
    {
        return $this->belongsTo(Player::class);
    }

    public function scopeQiwi($query)
    {
        return $query->whereHas('payment_system_direction', function($query2) {
            return $query2->whereHas('payment_system', function($query3) {
                return $query3->where('slug', 'qiwi');
            });
        });
    }

    public function scopeQiwiComment($query)
    {
        return $query->whereHas('payment_system_direction', function($query2) {
            return $query2->whereHas('payment_system', function($query3) {
                return $query3->where('slug', 'qiwi_comment');
            });
        });
    }

    public function scopeWaiting($query)
    {
        return $query->where('status', self::STATUS_WAITING);
    }

    public function scopeSuccess($query)
    {
        return $query->where('status', self::STATUS_SUCCESS);
    }
}
