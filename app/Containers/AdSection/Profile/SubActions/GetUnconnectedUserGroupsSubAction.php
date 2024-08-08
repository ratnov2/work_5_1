<?php

namespace App\Containers\AdSection\Profile\SubActions;

use App\Containers\AdSection\User\Models\User;
use App\Containers\SocialSection\Vk\Tasks\GetGroupsTask;

final class GetUnconnectedUserGroupsSubAction
{
    public function run(User $user)
    {
        $groups = app(GetGroupsTask::class)->run($user->access_token, ['filter' => 'admin']);

        $groups = collect($groups);

        $connected_group_vk_id = $user->vkGroups()->pluck('vk_id')->toArray();

        return $groups->filter(function($group) use($connected_group_vk_id) {
            return !in_array($group['id'], $connected_group_vk_id);
        });
    }
}
