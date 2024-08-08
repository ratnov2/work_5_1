<?php

namespace App\Containers\Player\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlayerRole extends Model
{
    use HasFactory;

    protected $table = 'player_roles';

    protected $fillable = ['name', 'slug'];

    public function scopeAdmin($query)
    {
        return $query->whereSlug('admin');
    }
}
