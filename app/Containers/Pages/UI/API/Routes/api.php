<?php

use App\Containers\Pages\UI\API\Controllers\PagesController;
use Illuminate\Support\Facades\Route;

Route::get('/server-timestamp', [PagesController::class, 'serverTimestamp']);

Route::get('/app', [PagesController::class, 'app']);
Route::get('/bonuses', [PagesController::class, 'bonuses']);
Route::get('/contests', [PagesController::class, 'contests']);
Route::get('/boxes', [PagesController::class, 'boxes']);
Route::get('/shop', [PagesController::class, 'shop']);
Route::get('/site', [PagesController::class, 'site']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/profile', [PagesController::class, 'profile']);
    Route::get('/ref-system', [PagesController::class, 'refSystem']);
    Route::get('/notifications', [PagesController::class, 'notifications']);
});

Route::prefix('/game-modes')->as('game-modes.')->group(function () {
    Route::get('/', [PagesController::class, 'gameModes']);
    Route::get('/top-contest', [PagesController::class, 'gameModesTopContest']);
    Route::get('/jackpot', [PagesController::class, 'gameModesJackpot']);
    Route::get('/upgrade', [PagesController::class, 'gameModesUpgrade']);
    Route::get('/boxes', [PagesController::class, 'gameModesBoxes']);
    Route::get('/mines', [PagesController::class, 'gameModesMines']);
    Route::get('/box', [PagesController::class, 'gameModesBox']);
});
