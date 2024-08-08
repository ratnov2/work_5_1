<?php

namespace App\Containers\Pages\Actions;

use App\Containers\BoxMoney\Tasks\GetBoxMoneyByIdTask;
use App\Containers\BoxMoney\UI\API\Resources\BoxMoneyResource;
use Illuminate\Support\Facades\View;

final class GetGameModesBoxViewAction
{
    public function run($box_id)
    {
        $box_money = app(GetBoxMoneyByIdTask::class)->run($box_id);

        $box_money_json = new BoxMoneyResource($box_money);

        return View::make("pages::pages.gameModes.pages.box.index", [
            'box_money_json' => $box_money_json
        ])->render();
    }
}
