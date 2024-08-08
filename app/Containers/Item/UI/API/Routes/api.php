<?php

use App\Containers\Item\UI\API\Controllers\ItemController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('items', [ItemController::class, 'items']);
});
