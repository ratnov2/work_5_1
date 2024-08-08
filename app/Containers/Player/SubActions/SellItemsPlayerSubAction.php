<?php

namespace App\Containers\Player\SubActions;

use App\Containers\Player\Data\Types\PlayerItemStatus;
use App\Containers\Player\Models\Player;
use App\Containers\Player\Tasks\CheckItemsPlayerForReadyTask;
use App\Containers\Player\Tasks\GetItemsPlayerByUniqidsTask;
use App\Containers\Player\Tasks\UpdateItemsPlayerByUniqidsTask;

final class SellItemsPlayerSubAction
{
    public function run(Player $player, ...$uniqids) : Player
    {
        $player_items = app(GetItemsPlayerByUniqidsTask::class)->run(true, ...$uniqids);
        app(CheckItemsPlayerForReadyTask::class)->run($player, ...$player_items);
        app(UpdateItemsPlayerByUniqidsTask::class)->run(
            ['status' => PlayerItemStatus::Sell],
            ...$player_items->map(fn($player_item) => $player_item->uniqid)
        );

        $player->balance += $player_items->sum('price');

        return $player;
    }
}
