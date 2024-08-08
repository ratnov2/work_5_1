<?php

namespace App\Containers\BoxLimit\Actions;

use App\Containers\Box\Events\NewBoxDropEvent;
use App\Containers\Box\SubActions\GetOpenBoxResultSubAction;
use App\Containers\BoxLimit\Exceptions\OpenBoxLimitException;
use App\Containers\BoxLimit\Tasks\GetBoxLimitByIdTask;
use App\Containers\Condition\Actions\ValidateConditionAction;
use App\Containers\Item\Tasks\GetRandomItemLowerThanTask;
use App\Containers\Player\SubActions\AddDropablePlayerItemsSubAction;
use App\Containers\Player\Tasks\GetAuthPlayerTask;
use Illuminate\Support\Facades\DB;

final class OpenBoxLimitAction
{
    public function run(string $mode, $id)
    {
        $box_limit = app(GetBoxLimitByIdTask::class)->run($id);
        if(!$box_limit) throw new OpenBoxLimitException('Лимитированный кейс не найден');

        $win_item = app(GetRandomItemLowerThanTask::class)->run($box_limit->max_item_price);
        if(!$win_item) throw new OpenBoxLimitException('Предметы в кейсе, в данный момент, не доступны. Попробуйте позже...');

        $player = app(GetAuthPlayerTask::class)->run();

        app(ValidateConditionAction::class)->run($player, $box_limit->condition);

        $player_item = DB::transaction(function () use($win_item, $player, $id) {
            $box_limit = app(GetBoxLimitByIdTask::class)->run($id, is_locked:true);
            if(!$box_limit) throw new OpenBoxLimitException('Лимитированный кейс не найден');

            if($box_limit->limit_left <= 0) throw new OpenBoxLimitException('Лимит кейса исчерпан');
            if($player->boxes_limit()->where('boxes_limit.id', $box_limit->id)->exists()) throw new OpenBoxLimitException('Вы уже открывали данный кейс');

            $box_limit->limit_left--;
            $box_limit->save();

            $player->boxes_limit()->attach($box_limit);
            return app(AddDropablePlayerItemsSubAction::class)->run($player, $box_limit, $win_item)[0];
        });

        event(new NewBoxDropEvent($mode, $player, $win_item));

        return app(GetOpenBoxResultSubAction::class)->run($mode, $win_item, $player_item, $box_limit->max_item_price);
    }
}
