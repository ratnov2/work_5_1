<?php

namespace App\Containers\Pages\Actions;

use App\Containers\BoxMoney\Models\BoxMoneyCategory;
use App\Containers\BoxMoney\UI\API\Resources\BoxMoneyResource;
use Illuminate\Support\Facades\View;

final class GetGameModesBoxesViewAction
{
    public function run()
    {
        $boxes_money_json_category_name = BoxMoneyCategory::with('boxes')
            ->orderBy('position')
            ->get()
            ->map(function($boxes_money_category) {
                $boxes_money_json = [];
                foreach ($boxes_money_category->boxes as $box)
                    $boxes_money_json[] = (new BoxMoneyResource($box))->toJson();

                return [
                    'category_name' => $boxes_money_category->name,
                    'boxes_money_json' => $boxes_money_json,
                ];
            });

        $params = [
            'boxes_money_json_category_name' => $boxes_money_json_category_name,
        ];

        return View::make("pages::pages.gameModes.pages.boxes.index")->with($params)->render();
    }
}
