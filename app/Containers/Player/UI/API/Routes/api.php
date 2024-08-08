<?php

use App\Containers\Player\UI\API\Controllers\PlayerController;
use App\Containers\Player\UI\API\Controllers\TelegramAccountController;
use App\Containers\Player\UI\API\Controllers\VkAccountController;
use Illuminate\Support\Facades\Route;

Route::get('/player', [PlayerController::class, 'player']);

Route::middleware('auth:sanctum')->prefix('player')->as('player.')->group(function() {
    Route::prefix('vk')->as('vk.')->group(function() {
        Route::post('dettach', [VkAccountController::class, 'dettach']);
    });
    
    Route::prefix('telegram')->as('telegram.')->group(function() {
        Route::post('dettach', [TelegramAccountController::class, 'dettach']);
    });
    
    Route::prefix('items')->as('items.')->group(function () {
        Route::get('load', [PlayerController::class, 'loadPlayerItems']);
        Route::get('load/ready', [PlayerController::class, 'loadPlayerItemsReady']);
    });
    
    Route::post('/item/sell', [PlayerController::class, 'itemSell']);
    Route::post('/trade-link', [PlayerController::class, 'tradeLink']);
});