<?php

namespace App\Containers\PaymentSection\PaymentSystem\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentSystemDirection extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'image',
        'id_in_payment_system',
        'payment_system_id',
        'is_active',
        'is_need_sum',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_need_sum' => 'boolean'
    ];

    public function scopeActive() {
        return $this->where('is_active', true);
    }

    public function payment_system()
    {
       return $this->belongsTo(PaymentSystem::class);
    }

    public function categories()
    {
        return $this->belongsToMany(PaymentSystemCategory::class, 'payment_system_direction_category', 'direction_id', 'category_id');
    }
}
