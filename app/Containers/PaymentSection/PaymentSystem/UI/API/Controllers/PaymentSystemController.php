<?php

namespace App\Containers\PaymentSection\PaymentSystem\UI\API\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Containers\PaymentSection\PaymentSystem\UI\API\Requests\MakePaymentRequest;
use App\Containers\PaymentSection\PaymentSystem\DTO\MakePaymentDTO;
use App\Containers\PaymentSection\PaymentSystem\Actions\MakePaymentAction;
use App\Containers\PaymentSection\PaymentSystem\Models\PaymentSystemCategory;
use App\Containers\PaymentSection\PaymentSystem\Models\PaymentSystemDirection;
use App\Containers\PaymentSection\PaymentSystem\UI\API\Resources\PaymentSystemCategoryResource;
use App\Containers\PaymentSection\PaymentSystem\UI\API\Resources\PaymentSystemDirectionResource;

class PaymentSystemController extends Controller
{
    public function make(MakePaymentRequest $request)
    {
        $params = $request->validated();

        $params['player_id'] = Auth::guard('players')->id();
        $params['sum'] = $request->sum ?? null;
        $params['promocode_value'] = $request->promocode_value ?? null;

        $dto = app(MakePaymentDTO::class)->fromArray($params);
        $data = app(MakePaymentAction::class)->run($dto);

        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }

    public function systemsInfo()
    {
        $directions = PaymentSystemDirectionResource::collection(PaymentSystemDirection::active()->get());
        $categories = PaymentSystemCategoryResource::collection(PaymentSystemCategory::get());

        return response()->json([
            'status' => 'success',
            'directions' => $directions,
            'categories' => $categories,
        ]);
    }
}
