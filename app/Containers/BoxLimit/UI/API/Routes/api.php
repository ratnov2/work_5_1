<?php

use App\Containers\BoxLimit\UI\API\Controllers\BoxLimitController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::prefix('boxes-limit')->as('boxes-limit.')->group(function () {
        Route::post('open', [BoxLimitController::class, 'openBoxLimit']);
    });
});
