<?php

use App\Containers\PaymentSection\Payment\UI\API\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::prefix('payment')->as('payment.')->group(function () {
        Route::post('check-promocode', [PaymentController::class, 'checkPromocode']);
    });
});

