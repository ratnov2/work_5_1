<?php

namespace App\Containers\Mines\UI\API\Controllers;

use App\Containers\Mines\Actions\OpenCellAction;
use App\Containers\Mines\Actions\StartAction;
use App\Containers\Mines\Actions\TakePrizeAction;
use App\Containers\Mines\UI\API\Requests\OpenCellRequest;
use App\Containers\Mines\UI\API\Requests\StartRequest;
use App\Containers\Mines\UI\API\Resources\PlayerMineGameResource;
use App\Http\Controllers\Controller;

class MinesController extends Controller
{
    public function start(StartRequest $request)
    {
        $result = app(StartAction::class)->run($request->uniqids, $request->count_mines);

        return response()->json([
            'status' => 'success',
            'mines_game' => new PlayerMineGameResource($result['mines_game']),
        ]);
    }

    public function openCell(OpenCellRequest $request)
    {
        $result = app(OpenCellAction::class)->run($request->cell_index);

        $params = [
            'status' => 'success',
            'mines_game' => new PlayerMineGameResource($result['mines_game']),
        ];

        if(isset($result['player_real_balance'])) $params['player_real_balance'] = $result['player_real_balance'];

        return response()->json($params);
    }

    public function takePrize()
    {
        $result = app(TakePrizeAction::class)->run();

        return response()->json([
            'status' => 'success',
            'mines_game' => new PlayerMineGameResource($result['mines_game']),
            'player_balance' => $result['player_balance']
        ]);
    }
}
