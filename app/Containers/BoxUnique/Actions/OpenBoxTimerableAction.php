<?php

namespace App\Containers\BoxUnique\Actions;

use App\Containers\Box\Events\NewBoxDropEvent;
use App\Containers\Box\SubActions\GetOpenBoxResultSubAction;
use App\Containers\BoxUnique\Exceptions\OpenBoxTimerableException;
use App\Containers\BoxUnique\Tasks\GetTimerableBoxTask;
use App\Containers\Condition\Actions\ValidateConditionAction;
use App\Containers\Player\SubActions\AddDropablePlayerItemsSubAction;
use App\Containers\Player\Tasks\GetAuthPlayerTask;
use App\Containers\Item\Tasks\GetRandomItemLowerThanTask;
use App\Containers\Player\Tasks\GetPlayerPaymentsSumTask;
use App\Containers\Settings\Tasks\GetSettingsBoxTask;
use Illuminate\Support\Facades\DB;

final class OpenBoxTimerableAction
{
    public function run(string $mode)
    {
        $settings_box = app(GetSettingsBoxTask::class)->run();
        if(!$settings_box->box_timer) throw new OpenBoxTimerableException('Данный кейс сейчас не доступен');

        $win_item = app(GetRandomItemLowerThanTask::class)->run($settings_box->box_timer_max_item_price);
        if(!$win_item) throw new OpenBoxTimerableException('Предметы в кейсе, в данный момент, не доступны. Попробуйте позже...');

        $player = app(GetAuthPlayerTask::class)->run();

        if($settings_box->box_timer_min_sum_payments_time_day != 0) {
            $sum_payments = app(GetPlayerPaymentsSumTask::class)->run($player, \Carbon\Carbon::now()->subDay());
            if($sum_payments < $settings_box->box_timer_min_sum_payments_time_day) throw new OpenBoxTimerableException('Для открытия кейса по таймеру необходимо пополнить баланс на ' . $settings_box->box_timer_min_sum_payments_time_day . ' монет за последний день.');
        }

        $box = app(GetTimerableBoxTask::class)->run();

        app(ValidateConditionAction::class)->run($player, $box->condition);

        $player_item = DB::transaction(function () use($win_item, $player, $box) {
            $player_item = DB::table('item_player')
                ->where('player_id', $player->id)
                ->where('dropable_type', get_class($box))
                ->where('dropable_id', $box->id)
                ->orderBy('created_at', 'desc')
                ->lockForUpdate()
                ->first();

            if(!is_null($player_item)) {
                if($player_item->created_at > \Carbon\Carbon::now()->subDay()) throw new OpenBoxTimerableException('Открытие кейса по таймеру доступно раз в 24 часа');
            }

            return app(AddDropablePlayerItemsSubAction::class)->run($player, $box, $win_item)[0];
        });

        event(new NewBoxDropEvent($mode, $player, $win_item));

        $result = app(GetOpenBoxResultSubAction::class)->run($mode, $win_item, $player_item, $settings_box->box_promocode_max_item_price);
        $result['time'] = \Carbon\Carbon::now();
        return $result;
    }
}
