<?php

namespace App\Containers\BoxMoney\Actions;

use App\Containers\Box\Events\NewBoxDropEvent;
use App\Containers\BoxMoney\Exceptions\OpenBoxMoneyException;
use App\Containers\BoxMoney\Tasks\GetBoxMoneyByIdTask;
use App\Containers\Player\SubActions\AddDropablePlayerItemsSubAction;
use App\Containers\Player\Tasks\GetAuthPlayerTask;
use App\Containers\Box\SubActions\GetOpenBoxResultSubAction;
use App\Containers\GameModes\Tasks\GetBankBoxesMoneyTask;
use App\Containers\Item\Tasks\GetItemLowerThanTask;
use App\Containers\Item\Tasks\GetRandomItemBetweenTask;
use Illuminate\Support\Facades\DB;

final class OpenBoxMoneyAction
{
    public function run(string $mode, $id)
    {
        $box = app(GetBoxMoneyByIdTask::class)->run($id);
        if(!$box) throw new OpenBoxMoneyException('Кейс не найден');

        $result = DB::transaction(function () use($box) {
            $bank_boxes_money= app(GetBankBoxesMoneyTask::class)->run(is_locked:true);
            $to_bank = $box->price * (100 - $box->profit_precent) / 100;
            $bank_boxes_money->value += $to_bank;

            $player = app(GetAuthPlayerTask::class)->run(is_locked:true);
            if($player->balance < $box->price) throw new OpenBoxMoneyException('Недостаточно средств');

            $max_item_price = $box->price * 20;
            $win_item = rand(0, 2) != 0
                ? app(GetRandomItemBetweenTask::class)->run($to_bank * 0.6, $to_bank * 0.7)
                : app(GetItemLowerThanTask::class)->run($bank_boxes_money->value > $max_item_price ? $max_item_price : $bank_boxes_money->value);

            if(!$win_item) throw new OpenBoxMoneyException('В данный момент, предметы в кейсе не доступны!');

            $player->balance -= $box->price;
            $player->save();

            $bank_boxes_money->value -= $win_item->price;
            $bank_boxes_money->save();

            $result['player'] = $player;
            $result['win_item'] = $win_item;
            $result['player_item'] = app(AddDropablePlayerItemsSubAction::class)->run($player, $box, $win_item)[0];

            return $result;
        });

        $data = app(GetOpenBoxResultSubAction::class)->run($mode, $result['win_item'], $result['player_item'], $box->price);
        $data['player_balance'] = $result['player']->balance;

        event(new NewBoxDropEvent($mode, $result['player'], $result['win_item']));

        return $data;
    }
}
