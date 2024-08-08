<?php

namespace App\Containers\AdSection\Auth\Actions;

use App\Containers\SocialSection\Vk\Tasks\GetAuthURLTask;

final class GetAuthVkURLAction
{
    public function run()
    {
        return app(GetAuthURLTask::class)->run(redirect_uri: route('ad.auth.vk.handle'), scope:array('offline', 'groups'));
    }
}
