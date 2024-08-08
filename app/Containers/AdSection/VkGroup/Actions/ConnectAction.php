<?php

namespace App\Containers\AdSection\VkGroup\Actions;

use App\Containers\SocialSection\Vk\Tasks\GetAuthURLTask;

final class ConnectAction
{
    public function run(...$group_ids)
    {
        return app(GetAuthURLTask::class)->run(
            redirect_uri: route('ad.vk.groups.handle'),
            scope: array('messages', 'manage', 'docs'),
            group_ids: $group_ids,
        );
    }
}
