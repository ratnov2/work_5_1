<?php

namespace App\Containers\BoxUnique\Actions;

use App\Containers\Box\Events\NewBoxDropEvent;
use App\Containers\Box\SubActions\GetOpenBoxResultSubAction;
use App\Containers\BoxUnique\Tasks\GetBoxPromocodeByValueTask;
use App\Containers\BoxUnique\Exceptions\OpenBoxPromocodableExceptiion;
use App\Containers\BoxUnique\Tasks\GetPromocodableBoxTask;
use App\Containers\Condition\Actions\ValidateConditionAction;
use App\Containers\Item\Tasks\GetRandomItemLowerThanTask;
use App\Containers\Player\SubActions\AddDropablePlayerItemsSubAction;
use App\Containers\Player\Tasks\GetAuthPlayerTask;
use App\Containers\Settings\Tasks\GetSettingsBoxTask;
use Illuminate\Support\Facades\DB;

final class OpenBoxPromocodableAction
{
    public function run(string $mode, string $promocode_value)
    {
        $settings_box = app(GetSettingsBoxTask::class)->run();
        if(!$settings_box->box_promocode) throw new OpenBoxPromocodableExceptiion('Данный кейс сейчас не доступен');

        $win_item = app(GetRandomItemLowerThanTask::class)->run($settings_box->box_promocode_max_item_price);
        if(!$win_item) throw new OpenBoxPromocodableExceptiion('Предметы в кейсе, в данный момент, не доступны. Попробуйте позже...');

        $player = app(GetAuthPlayerTask::class)->run();
        $box = app(GetPromocodableBoxTask::class)->run();

        app(ValidateConditionAction::class)->run($player, $box->condition);

        $player_item = DB::transaction(function () use($promocode_value, $win_item, $player, $box) {
            $box_promocode = app(GetBoxPromocodeByValueTask::class)->run($promocode_value, is_locked:true);

            if(!$box_promocode) throw new OpenBoxPromocodableExceptiion('Промокод не найден');

            if($player->box_promocodes()->where('box_promocode_id', $box_promocode->id)->exists()) throw new OpenBoxPromocodableExceptiion('Вы уже использовали данный промокод');

            if(!is_null($box_promocode->limit)) {
                if($box_promocode->limit <= 0) throw new OpenBoxPromocodableExceptiion('Лимит промокода исчерпан');
                $box_promocode->limit--;
                $box_promocode->save();
            }

            $player->box_promocodes()->attach($box_promocode);
            return app(AddDropablePlayerItemsSubAction::class)->run($player, $box, $win_item)[0];
        });

        event(new NewBoxDropEvent($mode, $player, $win_item));

        return app(GetOpenBoxResultSubAction::class)->run($mode, $win_item, $player_item, $settings_box->box_promocode_max_item_price);
    }
}
