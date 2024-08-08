<?php

namespace App\Containers\AdSection\Auth\Actions;

use App\Containers\AdSection\User\Models\User;
use App\Containers\SocialSection\Vk\Tasks\GetAccessTokenTask;
use App\Containers\SocialSection\Vk\Tasks\GetUserInfoTask;

final class HandleAuthVkAction
{
    public function run($code) : User
    {
        $access_token = app(GetAccessTokenTask::class)->run($code, route('ad.auth.vk.handle'));

        $user_info = app(GetUserInfoTask::class)->run($access_token);

        return User::updateOrCreate(
            [
                'vk_id' => $user_info['id']
            ],
            [
                'name' => $user_info['first_name'] . " " . $user_info['last_name'],
                'vk_id' => $user_info['id'],
                'image' => $user_info['photo_200'],
                'access_token' => $access_token,
            ]
        );
    }
}
