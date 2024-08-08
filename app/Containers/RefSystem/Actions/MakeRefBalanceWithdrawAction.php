<?php

namespace App\Containers\RefSystem\Actions;

use App\Containers\Player\Tasks\GetAuthPlayerTask;
use App\Containers\RefSystem\Exceptions\API\RefSystemException;
use App\Containers\RefSystem\Models\RefBalanceWithdraw;
use Illuminate\Support\Facades\DB;

final class MakeRefBalanceWithdrawAction
{
    public function run($sum)
    {
        if($sum <= 50) throw new RefSystemException('Сумма должна быть больше 50');

        return DB::transaction(function () use($sum) {
            $player = app(GetAuthPlayerTask::class)->run(is_locked: true);
            if($player->ref_balance < $sum) throw new RefSystemException('Недостаточно средств на реферальном балансе');
            $player->balance += $sum;
            $player->ref_balance -= $sum;
            $player->save();

            RefBalanceWithdraw::create([
                "sum" => $sum,
                "referrer_id" => $player->id,
                "status" => RefBalanceWithdraw::STATUS_SUCCESS
            ]);

            return [
                'ref_balance' => $player->ref_balance,
                'balance' => $player->balance
            ];
        });
    }
}
