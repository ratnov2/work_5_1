<?php

namespace App\Containers\AdSection\User\Models;

use App\Containers\AdSection\VkGroup\Models\VkGroup;
use betterapp\LaravelDbEncrypter\Traits\EncryptableDbAttribute;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use EncryptableDbAttribute;
       
    /** @var array The attributes that should be encrypted/decrypted */
    protected $encryptable = [
        'access_token',
    ];

    protected $table = 'ad_users';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'vk_id',
        'image',
        'access_token',
    ];

    protected $casts = [
        'confirmation' => 'boolean'
    ];

    public function vkGroups()
    {
        return $this->belongsToMany(VkGroup::class, 'ad_users_vk_groups', 'user_id', 'vk_group_id');
    }
}
