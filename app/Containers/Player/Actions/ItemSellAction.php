<?php

namespace App\Containers\Player\Actions;

use App\Containers\Player\SubActions\SellItemsPlayerSubAction;
use App\Containers\Player\Tasks\GetAuthPlayerTask;
use Illuminate\Support\Facades\DB;

final class ItemSellAction
{
    public function run(...$uniqids)
    {
        DB::beginTransaction();
        try {
            $player = app(GetAuthPlayerTask::class)->run(is_locked:true);
            $player = app(SellItemsPlayerSubAction::class)->run($player, ...$uniqids);
            $player->save();

            DB::commit();
            return $player->balance;

        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
}
