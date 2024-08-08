<?php

namespace App\Containers\PaymentSection\PaymentSystem\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentSystem extends Model
{
    use HasFactory;

    protected $table = 'payment_systems';

    protected $with = [
        'directions'
    ];

    protected $fillable = [
        'name',
        'slug',
    ];

    public function directions()
    {
        return $this->hasMany(PaymentSystemDirection::class)->where('is_active', true);
    }
}
