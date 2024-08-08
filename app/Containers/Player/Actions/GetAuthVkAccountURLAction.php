<?php

namespace App\Containers\Player\Actions;

use App\Containers\SocialSection\Vk\Tasks\GetAuthURLTask;

final class GetAuthVkAccountURLAction
{
    public function run()
    {
        return app(GetAuthURLTask::class)->run(redirect_uri: route('player.vk.attach'), scope:array('offline'));
    }
}
