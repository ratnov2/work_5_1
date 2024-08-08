<?php

use App\Containers\RefSystem\UI\API\Controllers\RefSystemController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::prefix('ref-system')->as('ref-system.')->group(function () {
        Route::post('make-ref-balance-withdraw', [RefSystemController::class, 'makeRefBalanceWithdraw']);
        Route::post('set-ref-code', [RefSystemController::class, 'setRefCode']);
    });
});
