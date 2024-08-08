<?php

namespace App\Containers\PaymentSection\Handle\Tasks;

use App\Containers\PaymentSection\Payment\Events\PaymentSuccessPaid;
use App\Containers\Player\Events\SendStorePlayerEvent;

final class HandleSuccessPaymentTask
{
    public function run($payment)
    {
        $final_sum = $payment->sum;

        if($payment->promocode) $final_sum += $payment->sum * ($payment->promocode->precent / 100);

        if($payment->player->referrer) {
            $final_sum += $payment->sum * $payment->player->referrer->ref_level->ref_bonus_precent / 100;
        }

        $player = $payment->player()->lockForUpdate()->first();
        $player->balance += $final_sum;
        $player->save();

        $payment->final_sum = $final_sum;
        $payment->status = $payment::STATUS_SUCCESS;
        $payment->save();

        event(new PaymentSuccessPaid($payment));
        event(new SendStorePlayerEvent($player->id, balance:$player->balance, msg:'Ваш счет пополнен. ID платежа: ' . $payment->id));
        return true;
    }
}
