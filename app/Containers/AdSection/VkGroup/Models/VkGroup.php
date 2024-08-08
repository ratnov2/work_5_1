<?php

namespace App\Containers\AdSection\VkGroup\Models;

use App\Containers\AdSection\User\Models\User;
use betterapp\LaravelDbEncrypter\Traits\EncryptableDbAttribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VkGroup extends Model
{
    use HasFactory;
    use EncryptableDbAttribute;
       
    /** @var array The attributes that should be encrypted/decrypted */
    protected $encryptable = [
        'access_token',
        'callback_server_secret_key', 
    ];

    protected $table = 'ad_vk_groups';

    protected $fillable = [
        'name',
        'image',
        'vk_id',
        'vk_short_name',
        'access_token',
        'callback_server_secret_key',
        'callback_server_id',
        'confirmation',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'ad_users_vk_groups', 'vk_group_id', 'user_id');
    }
}
