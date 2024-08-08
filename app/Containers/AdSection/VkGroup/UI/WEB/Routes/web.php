<?php

use App\Containers\AdSection\VkGroup\UI\WEB\Controllers\ConnectController;
use Illuminate\Support\Facades\Route;

Route::prefix('ad/vk')->as('ad.vk.')->group(function() {
    Route::post('groups/connect', [ConnectController::class, 'connect'])->name('groups.connect')->middleware(['auth:sanctum', 'ad.auth']);;
    Route::get('groups/handle', [ConnectController::class, 'handle'])->name('groups.handle');
});
