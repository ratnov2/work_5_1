<?php

namespace App\Containers\Contest\Models;

use App\Containers\Condition\Models\Condition;
use App\Containers\Contest\Data\Types\Status;
use App\Containers\Item\Models\Item;
use App\Containers\Player\Models\Player;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contest extends Model
{
    use HasFactory, AsSource, Filterable, SoftDeletes;

    protected $dates = [
        'created_at',
        'updated_at',
        'end_at',
        'reserved_at',
    ];

    protected $with = [
        'item', 'condition'
    ];

    protected $fillable = [
        'market_hash_name', 'status', 'reserved_at', 'end_at', 'type', 'position'
    ];

    protected $casts = [
        'status' => Status::class,
    ];

    public function condition()
    {
        return $this->morphOne(Condition::class, 'conditionable');
    }

    public function players()
    {
        return $this->belongsToMany(Player::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class, 'market_hash_name', 'market_hash_name');
    }

    public function win_player()
    {
        return $this->belongsTo(Player::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', Status::Active);
    }

    public function scopeFinish($query)
    {
        return $query->where('status', Status::Finish);
    }

    public function scopeWait($query)
    {
        return $query->where('status', Status::Wait);
    }
}
