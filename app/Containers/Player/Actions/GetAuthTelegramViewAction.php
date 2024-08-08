<?php

namespace App\Containers\Player\Actions;

use App\Containers\SocialSection\Telegram\Tasks\GetAuthViewTask;

final class GetAuthTelegramViewAction
{
    public function run()
    {
        return app(GetAuthViewTask::class)->run(redirect_uri: route('player.telegram.attach'));
    }
}
