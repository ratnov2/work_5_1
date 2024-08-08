<?php

use App\Containers\BoxUnique\UI\API\Controllers\BoxController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::prefix('boxes')->as('boxes.')->group(function () {
        Route::post('timer/open', [BoxController::class, 'openBoxTimerable']);
        Route::post('promocode/open', [BoxController::class, 'openBoxPromocodable']);
    });
});
