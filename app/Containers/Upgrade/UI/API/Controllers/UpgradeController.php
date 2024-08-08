<?php

namespace App\Containers\Upgrade\UI\API\Controllers;

use App\Http\Controllers\Controller;
use App\Containers\Upgrade\Actions\MakeUpgradeAction;
use App\Containers\Upgrade\DTO\MakeUpgradeDTO;
use App\Containers\Upgrade\UI\API\Requests\MakeUpgradeRequest;

class UpgradeController extends Controller
{
    public function makeUpgrade(MakeUpgradeRequest $request)
    {
        $dto = app(MakeUpgradeDTO::class)->fromRequest($request);

        $data = app(MakeUpgradeAction::class)->run($dto);

        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }
}
