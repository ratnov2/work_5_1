<?php

use App\Containers\Auth\UI\Controllers\FakeAuthController;
use App\Containers\Auth\UI\Controllers\SteamAuthController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'guest:players'], function () {
    Route::get('auth/steam', [SteamAuthController::class, 'redirectToSteam'])->name('auth.steam');
    Route::get('auth/steam/handle', [SteamAuthController::class, 'handle'])->name('auth.steam.handle');
});

Route::group(['middleware' => 'auth:players'], function () {
    Route::any('logout', [SteamAuthController::class, 'logout'])->name('logout');
});