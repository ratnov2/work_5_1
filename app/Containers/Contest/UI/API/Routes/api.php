<?php

use Illuminate\Support\Facades\Route;
use App\Containers\Contest\UI\API\Controllers\ContestController;

Route::prefix('contests')->as('contests.')->group(function () {
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::post('enter', [ContestController::class, 'enter']);
    });
});
