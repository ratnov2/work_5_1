<?php

namespace App\Containers\SocialSection\Vk\Tasks;

use Illuminate\Support\Facades\Http;

final class GroupsSetSettingsTask
{
    public function run(string $access_token, array $params)
    {
        $params['access_token'] = $access_token;

        return Http::get('https://api.vk.com/method/groups.setSettings' . '?' . urldecode(http_build_query($params)));
    }
}
