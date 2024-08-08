<?php

namespace App\Containers\Pages\Actions;

use App\Containers\Player\Tasks\GetAuthPlayerTask;
use App\Containers\RefSystem\Tasks\GetReferralsSumOfPaymentsTask;
use App\Containers\RefSystem\Tasks\GetRefLevelsTask;
use Illuminate\Support\Facades\View;

final class GetRefSystemViewAction
{
    public function run()
    {
        $player = app(GetAuthPlayerTask::class)->run();

        $ref_levels = app(GetRefLevelsTask::class)->run();

        $sum_payments_referrals = app(GetReferralsSumOfPaymentsTask::class)->run($player);

        $page = View::make("pages::pages.refSystem.index")->with([
            'player' => $player,
            'ref_levels' => $ref_levels,
            'sum_payments_referrals' => $sum_payments_referrals
        ])->render();

        return $page;
    }
}
