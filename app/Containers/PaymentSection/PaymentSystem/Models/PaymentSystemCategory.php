<?php

namespace App\Containers\PaymentSection\PaymentSystem\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentSystemCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
    ];

    public function payment_system_directions()
    {
       return $this->belongsTo(PaymentSystemDirection::class);
    }
}
