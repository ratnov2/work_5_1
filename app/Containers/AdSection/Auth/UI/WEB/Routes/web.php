<?php

use App\Containers\AdSection\Auth\UI\WEB\Controllers\AuthController;
use App\Containers\AdSection\Auth\UI\WEB\Controllers\VkController;
use Illuminate\Support\Facades\Route;

Route::prefix('ad/auth')->as('ad.auth.')->group(function() {
    Route::middleware('ad.guest')->group(function() {
        Route::post('/vk/login', [VkController::class, 'login'])->name('vk.login');
        Route::get('/vk/handle', [VkController::class, 'handle'])->name('vk.handle');
    });

    Route::middleware(['auth:sanctum', 'ad.auth'])->group(function() {
        Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    });
});
