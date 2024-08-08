<?php

namespace App\Containers\SocialSection\Vk\Tasks;

final class GetAuthURLTask
{
    public function run(string $redirect_uri, array $scope = [], array $group_ids = null) : string
    {
        $config = config('services.vkontakte');
        $client_id = $config['client_id'];
        $redirect_uri = $redirect_uri;

        $oauth = new \VK\OAuth\VKOAuth();
        $display = \VK\OAuth\VKOAuthDisplay::PAGE;
        $state = 'secret_state_code';
        $scope = is_null($group_ids) ? $this->getUserScope($scope) : $this->getGroupScope($scope);

        return $oauth->getAuthorizeUrl(\VK\OAuth\VKOAuthResponseType::CODE, $client_id, $redirect_uri, $display, $scope, $state, $group_ids);
    }

    private function getUserScope(array $scope) : array
    {
        $result = [];
        $values = [
            'groups' => \VK\OAuth\Scopes\VKOAuthUserScope::GROUPS,
            'offline' => \VK\OAuth\Scopes\VKOAuthUserScope::OFFLINE,
            'messages' => \VK\OAuth\Scopes\VKOAuthUserScope::MESSAGES,
            'photos' => \VK\OAuth\Scopes\VKOAuthUserScope::PHOTOS,
            'wall' => \VK\OAuth\Scopes\VKOAuthUserScope::WALL,
            'docs' => \VK\OAuth\Scopes\VKOAuthUserScope::DOCS,
        ];

        foreach ($scope as $param)
            if(isset($values[$param])) $result[] = $values[$param];

        return $result;
    }

    private function getGroupScope(array $scope) : array
    {
        $result = [];
        $values = [
            'photos' => \VK\OAuth\Scopes\VKOAuthGroupScope::PHOTOS,
            'app_widget' => \VK\OAuth\Scopes\VKOAuthGroupScope::APP_WIDGET,
            'messages' => \VK\OAuth\Scopes\VKOAuthGroupScope::MESSAGES,
            'manage' => \VK\OAuth\Scopes\VKOAuthGroupScope::MANAGE,
        ];

        foreach ($scope as $param)
            if(isset($values[$param])) $result[] = $values[$param];

        return $result;
    }
}
