<?php

namespace App\Containers\BoxLimit\UI\API\Controllers;

use App\Containers\BoxLimit\Actions\OpenBoxLimitAction;
use App\Containers\BoxLimit\Requests\OpenBoxLimitRequest;
use App\Http\Controllers\Controller;

class BoxLimitController extends Controller
{
    public function openBoxLimit(OpenBoxLimitRequest $request)
    {
        $data = app(OpenBoxLimitAction::class)->run($request->mode, $request->box_id);

        return response()->json([
            'status' => 'success',
            'data' => $data,
        ]);
    }
}

