<?php

use App\Containers\Chat\UI\API\Controllers\ChatController;
use App\Containers\Chat\UI\API\Controllers\ModeratorChatController;
use Illuminate\Support\Facades\Route;

Route::prefix('chat')->as('chat.')->group(function() {
    Route::middleware('auth:sanctum')->group(function() {
        Route::post('send', [ChatController::class, 'send'])->name('send');
        Route::middleware('can:moderate-chat')->group(function() {
            Route::post('player/unmute', [ModeratorChatController::class, 'playerUnmute'])->name('playerUnmute');
            Route::post('player/mute', [ModeratorChatController::class, 'playerMute'])->name('playerMute');
            Route::post('message/delete', [ModeratorChatController::class, 'messageDelete'])->name('messageDelete');
        });
    });
});
