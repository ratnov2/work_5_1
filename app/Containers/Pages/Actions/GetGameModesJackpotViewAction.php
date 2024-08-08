<?php

namespace App\Containers\Pages\Actions;

use App\Containers\Jackpot\Models\Jackpot;
use App\Containers\Jackpot\UI\API\Resources\JackpotHistoryResource;
use App\Containers\Jackpot\UI\API\Resources\JackpotResource;
use Illuminate\Support\Facades\View;

final class GetGameModesJackpotViewAction
{
    public function run()
    {
        $params = [
            'jackpot_json' => (new JackpotResource(Jackpot::latest('id')->first()))->toJson(),
            'jackpots_history_json' => JackpotHistoryResource::collection(Jackpot::end()->latest('id')->limit(5)->get())->toJson(),
        ];

        return View::make('pages::pages.gameModes.pages.jackpot.index')->with($params)->render();
    }
}
