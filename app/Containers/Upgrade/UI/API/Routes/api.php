<?php

use App\Containers\Upgrade\UI\API\Controllers\UpgradeController;
use Illuminate\Support\Facades\Route;

Route::prefix('/upgrade')->as('upgrade.')->group(function() {
    Route::get('/load-content', [UpgradeController::class, 'loadContent']);
    Route::middleware(['auth:sanctum'])->prefix('/player')->as('player.')->group(function () {
        Route::post('/make', [UpgradeController::class, 'makeUpgrade']);
    });
});
