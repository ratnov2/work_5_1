<?php

use App\Containers\BoxMoney\UI\API\Controllers\BoxMoneyController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::prefix('boxes-money')->as('boxes-money.')->group(function () {
        Route::post('open', [BoxMoneyController::class, 'openBoxMoney']);
    });
});
