<?php

namespace App\Containers\Player\UI\API\Controllers;

use App\Containers\Player\Actions\ItemSellAction;
use App\Containers\Player\Actions\LoadPlayerItemsAction;
use App\Containers\Player\Actions\LoadPlayerItemsReadyAction;
use App\Containers\Player\Actions\TradeLinkAction;
use App\Containers\Player\Exceptions\API\ProfileException;
use App\Containers\Player\Tasks\GetAuthPlayerTask;
use App\Containers\Player\UI\API\Resources\PlayerResource;
use App\Http\Controllers\Controller;
use denis660\Centrifugo\Centrifugo;
use Illuminate\Http\Request;

class PlayerController extends Controller
{
    public function player(Centrifugo $centrifugo)
    {
        $player = app(GetAuthPlayerTask::class)->run();

        $centrifugo_token = $player ? $centrifugo->generateConnectionToken((string) $player->id, 0, ['name' => $player->name]) : null;
        $player = $player ? new PlayerResource($player) : null;

        return response()->json([
            'status' => 'success',
            'player' => $player,
            'centrifugo_token' => $centrifugo_token,
        ]);
    }

    public function itemSell(Request $request)
    {
        if (!$request->uniqid) throw new ProfileException('Укажите уникальный идентификатор предмета');

        $player_balance = app(ItemSellAction::class)->run($request->uniqid);

        return response()->json([
            'status' => 'success',
            'msg' => 'Предмет успешно продан',
            'player_balance' => round($player_balance, 2),
        ]);
    }

    public function tradeLink(Request $request)
    {
        if (!$request->has('trade_link')) throw new ProfileException('Укажите trade-ссылку');

        app(TradeLinkAction::class)->run($request->get('trade_link'));

        return response()->json([
            'status' => 'success',
            'msg' => 'Trade-ссылка успешно обновлена'
        ]);
    }

    public function loadPlayerItems()
    {
        $data = app(LoadPlayerItemsAction::class)->run();

        return response()->json([
            'status' => 'success',
            ...$data
        ]);
    }

    public function loadPlayerItemsReady()
    {
        $data = app(LoadPlayerItemsReadyAction::class)->run();

        return response()->json([
            'status' => 'success',
            ...$data
        ]);
    }
}
