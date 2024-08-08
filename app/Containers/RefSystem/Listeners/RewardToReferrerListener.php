<?php

namespace App\Containers\RefSystem\Listeners;

use App\Containers\PaymentSection\Payment\Events\PaymentSuccessPaid;
use App\Containers\Player\Models\Player;
use App\Containers\RefSystem\Models\RefLevel;
use App\Containers\RefSystem\Models\RefReward;
use App\Containers\RefSystem\Tasks\GetReferralsSumOfPaymentsTask;

class RewardToReferrerListener
{
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(PaymentSuccessPaid $event)
    {
        $payment = $event->payment;
        if(is_null($payment->player->referrer)) return;
        $referrer = Player::where('id', $payment->player->referrer->id)->lockForUpdate()->first();

        // Проверка на некст левел
        if($referrer->ref_level->type != 'custom') {
            $sum_payments = app(GetReferralsSumOfPaymentsTask::class)->run($referrer);
            $next_ref_level = RefLevel::where([
                ['type', $referrer->ref_level->type],
                ['sum_payments', '<=', $sum_payments]
            ])->orderBy('level', 'desc')->first();

            if($next_ref_level && $next_ref_level->id != $referrer->ref_level->id) $referrer->ref_level_id = $next_ref_level->id;
        }

        // Выдача награды
        $referrer_reward = $payment->sum * ($referrer->ref_level->bonus_precent / 100);
        $referrer->ref_balance += $referrer_reward;
        RefReward::create([
            'payment_id' => $payment->id,
            'referrer_id' => $referrer->id,
            'referral_id' => $payment->player->id,
            'reward' => $referrer_reward,
        ]);

        $referrer->save();
    }
}
