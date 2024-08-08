<?php

use App\Containers\Player\UI\WEB\Controllers\VkAccountController;
use App\Containers\Player\UI\WEB\Controllers\TelegramAccountController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->prefix('player/vk')->as('player.vk.')->group(function() {
    Route::get('auth', [VkAccountController::class, 'auth'])->name('auth');
    Route::get('attach', [VkAccountController::class, 'attach'])->name('attach');
});

Route::middleware('auth:sanctum')->prefix('player/telegram')->as('player.telegram.')->group(function() {
    Route::get('auth', [TelegramAccountController::class, 'auth'])->name('auth');
    Route::get('attach', [TelegramAccountController::class, 'attach'])->name('attach');
});
