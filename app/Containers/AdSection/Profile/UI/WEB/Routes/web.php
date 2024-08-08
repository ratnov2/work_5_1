<?php

use App\Containers\AdSection\Profile\UI\WEB\Controllers\PageController;
use Illuminate\Support\Facades\Route;

Route::prefix('ad')->as('ad.')->group(function() {
    Route::get('/login', [PageController::class, 'login'])->name('login.view')->middleware('ad.guest');

    Route::middleware(['ad.auth'])->prefix('profile')->as('profile.')->group(function() {
        Route::get('/', [PageController::class, 'index'])->name('index');
        Route::get('/vk/groups', [PageController::class, 'vkGroups'])->name('vk.groups');
    });
});
