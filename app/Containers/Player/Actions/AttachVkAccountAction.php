<?php

namespace App\Containers\Player\Actions;

use App\Containers\Player\Exceptions\WEB\ProfileException;
use App\Containers\Player\Models\Player;
use App\Containers\Player\Tasks\AttachPlayerVkAccountTask;
use App\Containers\Player\Tasks\GetAuthPlayerTask;
use App\Containers\SocialSection\Vk\Tasks\GetAccessTokenTask;
use App\Containers\SocialSection\Vk\Tasks\GetUserInfoTask;

final class AttachVkAccountAction
{
    public function run($code)
    {
        $player = app(GetAuthPlayerTask::class)->run();

        if($player->vkAccount()->exists()) throw new ProfileException('Аккаунт VK уже привязан');

        $access_token = app(GetAccessTokenTask::class)->run($code, route('player.vk.attach'));

        $user_info = app(GetUserInfoTask::class)->run($access_token);

        if(Player::where('id', '<>', $player->id)->whereHas('vkAccount', function($q) use($user_info) {
            $q->where('vk_id', $user_info['id']);
        })->exists()) {
            throw new ProfileException('Этот аккаунт VK уже используется другим игроком');
        }

        $params = [
            'name' => $user_info['first_name'] . " " . $user_info['last_name'],
            'vk_id' => $user_info['id'],
            'image' => $user_info['photo_200'],
            'access_token' => $access_token,
        ];

        app(AttachPlayerVkAccountTask::class)->run($player, $params);
    }
}
