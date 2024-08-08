<?php

use App\Containers\Jackpot\UI\API\Controllers\JackpotServiceController;
use App\Containers\Jackpot\UI\API\Controllers\JackpotController;
use Illuminate\Support\Facades\Route;

Route::prefix('/jackpot')->as('jackpot.')->group(function() {
    Route::get('/load-content', [JackpotController::class, 'loadContent']);

    Route::prefix('/service')->as('service.')->middleware('game_mode_secret')->group(function() {
        Route::post('/ping', [JackpotServiceController::class, 'ping']);
        Route::post('/active', [JackpotServiceController::class, 'active']);
        Route::post('/end', [JackpotServiceController::class, 'end']);
    });

    Route::prefix('/player')->as('player.')->group(function() {
        Route::post('/bet', [JackpotController::class, 'makeBet']);
    });
});
