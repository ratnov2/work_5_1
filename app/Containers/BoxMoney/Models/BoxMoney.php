<?php

namespace App\Containers\BoxMoney\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Orchid\Screen\AsSource;

class BoxMoney extends Model
{
    use HasFactory, AsSource, SoftDeletes;

    protected $table = 'boxes_money';

    protected $fillable = [
        'name', 
        'image', 
        'price', 
        'category_id', 
        'profit_precent'
    ];

    public function category()
    {
        return $this->belongsTo(BoxMoneyCategory::class, 'category_id');
    }
}
