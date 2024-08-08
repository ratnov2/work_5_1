<?php

namespace App\Containers\BoxMoney\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class BoxMoneyCategory extends Model
{
    use HasFactory, AsSource;

    protected $table = 'boxes_money_categories';

    protected $fillable = [
        'name', 'position'
    ];

    public function boxes()
    {
        return $this->hasMany(BoxMoney::class, 'category_id');
    }
}
