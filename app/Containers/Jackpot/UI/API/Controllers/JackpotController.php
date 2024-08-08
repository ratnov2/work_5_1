<?php

namespace App\Containers\Jackpot\UI\API\Controllers;

use App\Http\Controllers\Controller;
use App\Containers\Jackpot\Actions\MakeBetAction;
use App\Containers\Jackpot\DTO\MakeBetDTO;
use App\Containers\Jackpot\UI\API\Requests\MakeBetRequest;

class JackpotController extends Controller
{
    public function makeBet(MakeBetRequest $request)
    {
        $dto = app(MakeBetDTO::class)->fromRequest($request);

        app(MakeBetAction::class)->run($dto);

        return response()->json([
            'status' => 'success',
            'msg' => 'Ваша ставка успешно принята'
        ]);
    }
}
