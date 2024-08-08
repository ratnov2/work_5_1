<?php

namespace App\Containers\BoxUnique\UI\API\Controllers;

use App\Containers\BoxUnique\Actions\OpenBoxPromocodableAction;
use App\Containers\BoxUnique\Actions\OpenBoxTimerableAction;
use App\Containers\BoxUnique\Requests\OpenBoxPromocodableRequest;
use App\Containers\BoxUnique\Requests\OpenBoxTimerableRequest;
use App\Http\Controllers\Controller;

class BoxController extends Controller
{
    public function openBoxTimerable(OpenBoxTimerableRequest $request)
    {
        $data = app(OpenBoxTimerableAction::class)->run($request->mode);

        return response()->json([
            'status' => 'success',
            'data' => $data,
        ]);
    }

    public function openBoxPromocodable(OpenBoxPromocodableRequest $request)
    {
        $data = app(OpenBoxPromocodableAction::class)->run($request->mode, $request->promocode_value);

        return response()->json([
            'status' => 'success',
            'data' => $data,
        ]);
    }
}

