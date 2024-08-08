<?php

use App\Containers\Withdraw\UI\API\Controllers\ItemWithdrawController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/player/item/withdraw', [ItemWithdrawController::class, 'itemWithdraw']);
});
