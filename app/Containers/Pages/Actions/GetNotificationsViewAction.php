<?php

namespace App\Containers\Pages\Actions;

use App\Containers\Player\Tasks\GetAuthPlayerTask;
use Illuminate\Support\Facades\View;

final class GetNotificationsViewAction
{
    public function run()
    {
        $player = app(GetAuthPlayerTask::class)->run();
        $player->unreadNotifications()->update(['read_at' => now()]);

        $player_notifications = $player->notifications()->get();
        $notifications = [];
        foreach ($player_notifications as $notification) {
            $date = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $notification->created_at)->setTimezone('Europe/Moscow')->format('Y-m-d');
            $notifications[$date][] = $notification;
        }

        $page = View::make("pages::pages.notifications.index")->with(['notifications' => $notifications, 'player_notifications' => $player_notifications])->render();

        return $page;
    }
}
