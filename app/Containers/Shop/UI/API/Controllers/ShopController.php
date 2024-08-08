<?php

namespace App\Containers\Shop\UI\API\Controllers;

use App\Http\Controllers\Controller;
use App\Containers\Shop\Actions\BuyItemsAction;
use App\Containers\Shop\DTO\BuyItemsDTO;
use App\Containers\Shop\UI\API\Requests\BuyItemsRequest;

class ShopController extends Controller
{
    public function accept(BuyItemsRequest $request)
    {
        $dto = app(BuyItemsDTO::class)->fromRequest($request);
        $result = app(BuyItemsAction::class)->run($dto);

        return response()->json([
            'status' => 'success',
            'msg' => 'Успешная покупка предметов',
            'player_items' => $result['player_items'],
            'player_balance' => $result['player_balance'],
        ]);
    }
}
