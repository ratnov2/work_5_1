<?php

namespace App\Containers\AdSection\Profile\UI\WEB\Controllers;

use App\Containers\AdSection\User\Tasks\GetAuthUserTask;
use App\Containers\SocialSection\Vk\Tasks\GetGroupsTask;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    public function login()
    {
        return view('adsection.profile::auth.login');
    }

    public function index()
    {
        $user = app(GetAuthUserTask::class)->run();

        return view('adsection.profile::index')->with([
            'user' => $user
        ]);
    }

    public function vkGroups()
    {
        try {
            $user = app(GetAuthUserTask::class)->run();

            $connected_groups = $user->vkGroups()->get();
            $unconnected_groups = collect(app(GetGroupsTask::class)->run($user->access_token, ['filter' => 'admin,owner']))
                ->filter(fn($group) => !in_array($group['id'], $connected_groups->pluck('vk_id')->toArray()));
    
            return view('adsection.profile::vk-groups')->with([
                'user' => $user,
                'connected_groups' => $connected_groups,
                'unconnected_groups' => $unconnected_groups,
            ]);
            
        } catch (\VK\Exceptions\Api\VKApiAuthException $th) {
            Auth::guard('ad_users')->logout();
            return redirect()->route('ad.login.view');

        } catch (\Throwable $th) {
            throw $th;
        }
    }
}

