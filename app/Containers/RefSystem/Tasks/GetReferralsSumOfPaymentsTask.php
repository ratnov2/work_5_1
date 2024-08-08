<?php

namespace App\Containers\RefSystem\Tasks;

use App\Containers\PaymentSection\Payment\Models\Payment;
use App\Containers\Player\Models\Player;

final class GetReferralsSumOfPaymentsTask
{
    public function run(Player $referrer)
    {
        return Payment::whereIn('player_id', $referrer->referrals->pluck('id')->toArray())
            ->where('status', Payment::STATUS_SUCCESS)
            ->sum('sum');
    }
}
