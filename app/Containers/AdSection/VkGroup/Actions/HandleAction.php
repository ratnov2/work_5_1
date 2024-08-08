<?php

namespace App\Containers\AdSection\VkGroup\Actions;

use App\Containers\AdSection\User\Tasks\GetAuthUserTask;
use App\Containers\AdSection\VkGroup\Exceptions\HandleException;
use App\Containers\AdSection\VkGroup\Models\VkGroup;
use App\Containers\SocialSection\Vk\Tasks\GetGroupsAccessTokenTask;
use App\Containers\SocialSection\Vk\Tasks\GetGroupsByIdTask;
use App\Containers\SocialSection\Vk\Tasks\GroupsAddCallbackServerTask;
use App\Containers\SocialSection\Vk\Tasks\GroupsGetCallbackConfirmationCodeTask;
use App\Containers\SocialSection\Vk\Tasks\GroupsSetCallbackSettingsTask;
use App\Containers\SocialSection\Vk\Tasks\GroupsSetSettingsTask;
use Illuminate\Support\Facades\DB;

final class HandleAction
{
    public function run(string $code) 
    {
        try {
            $user = app(GetAuthUserTask::class)->run();
    
            # Запрос на получение токенов групп
            $groups_access_tokens = collect(app(GetGroupsAccessTokenTask::class)->run($code, route('ad.vk.groups.handle')));
    
            # Получение информации о группах
            $group_ids = $groups_access_tokens->map(fn($group_access_token) => $group_access_token['group_id'])->implode(',');
            $groups = collect(app(GetGroupsByIdTask::class)->run($user->access_token, ['group_ids' => $group_ids]));

            # Обработка каждой группы
            $groups_access_tokens = $groups_access_tokens->keyBy('group_id');
    
            DB::transaction(function () use($user, $groups, $groups_access_tokens) {
                $vk_group_ids = [];
                foreach ($groups as $group) {
                    $vk_group = VkGroup::updateOrCreate(
                        [
                            'vk_id' => $group['id'], 
                            'vk_short_name' => $group['screen_name']
                        ],
                        [
                            'vk_id' => $group['id'],
                            'vk_short_name' => $group['screen_name'],
                            'name'  => $group['name'],
                            'image' => $group['photo_200'],
                            'access_token' => $groups_access_tokens[$group['id']]['access_token'],
                        ]
                    );
                    $vk_group_ids[] = $vk_group->id;
                }
                $user->vkGroups()->syncWithoutDetaching($vk_group_ids);
            });
    
            return redirect()->route('ad.profile.vk.groups')->with([
                'status' => 'success',
                'msg'    => 'Группа(-ы) успешно подключена(-ы)!'
            ]);
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
    }

    private function setSettings($access_token, $group)
    {
        try {
            app(GroupsSetSettingsTask::class)->run($access_token, [
                'group_id'          => $group['id'],
                'messages'          => 1,
                'bots_capabilities' => 1,
            ]);
        } catch (\Throwable $th) {
            throw new HandleException('Ошибка установки настроек группы!');
        }
    }

    private function getConfirmationCode($access_token, $group)
    {
        try {
            return app(GroupsGetCallbackConfirmationCodeTask::class)->run($access_token, [
                'group_id' => $group['id'],
            ]);
        } catch (\Throwable $th) {
            throw new HandleException('Ошибка получения confirmation токена!');
        }
    }

    private function addCallbackServer($access_token, $group, $callback_server_secret_key)
    {
        try {
            return app(GroupsAddCallbackServerTask::class)->run($access_token, [
                'group_id'   => $group['id'],
                'url'        => config('app.url') . '/api/ad/vk/group/callback',
                'title'      => config('app.name', 'Ad System'),
                'secret_key' => $callback_server_secret_key,
            ]);
        } catch (\Throwable $th) {
            throw new HandleException('Ошибка создания callback сервера!');
        }
    }

    private function setCallbackSettings($access_token, $group, $callback_server_id)
    {
        try {
            app(GroupsSetCallbackSettingsTask::class)->run($access_token, [
                'group_id'      => $group['id'],
                'server_id'     => $callback_server_id,
                'message_new'   => true,
                'message_reply' => true,
                'wall_repost'   => true,
                'like_add'      => true,
                'like_remove'   => true,
                'group_join'    => true,
                'group_leave'   => true,
            ]);
        } catch (\Throwable $th) {
            throw new HandleException('Ошибка установки настроек callback сервера!');
        }
    }
}
