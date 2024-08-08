<?php

namespace App\Containers\Contest\UI\API\Controllers;

use App\Containers\Contest\Actions\EnterContestAction;
use App\Containers\Contest\Requests\EnterContestRequest;
use App\Http\Controllers\Controller;

class ContestController extends Controller
{
    public function enter(EnterContestRequest $request) {
        app(EnterContestAction::class)->run($request->contest_id);

        return response()->json([
            'status' => 'success',
            'msg' => 'Вы успешно приняли участие в конкурсе!'
        ]);
    }
}
