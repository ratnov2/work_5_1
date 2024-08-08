<?php

namespace App\Containers\Contest\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PlayerWinContest extends Notification
{
    use Queueable;

    public $contest;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($contest)
    {
        $this->contest = $contest;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'msg' => 'Вы победили в нашем розыгрыше скина ' . $this->contest->market_hash_name . '!' . ' Поздравляем! Скин можно вывести в профиле',
        ];
    }
}
