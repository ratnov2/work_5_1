<?php

use App\Containers\Shop\UI\API\Controllers\ShopController;
use Illuminate\Support\Facades\Route;

Route::prefix('shop')->as('shop.')->group(function () {
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::post('accept', [ShopController::class, 'accept'])->name('accept');
    });
});
