<?php

use App\Containers\Mines\UI\API\Controllers\MinesController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->prefix('mines')->as('mines.')->group(function() {
    Route::post('/start', [MinesController::class, 'start']);
    Route::post('/open-cell', [MinesController::class, 'openCell']);
    Route::get('/take-prize', [MinesController::class, 'takePrize']);
});