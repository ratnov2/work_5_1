<?php

use App\Containers\SiteQuest\UI\API\Controllers\SiteQuestController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->prefix('site')->as('site.')->group(function () {
    Route::prefix('quest')->as('quest.')->group(function () {
        Route::post('take', [SiteQuestController::class, 'takeQuest']);
        Route::post('check-in-start', [SiteQuestController::class, 'checkInStartSiteQuest']);
        Route::post('check-in-working', [SiteQuestController::class, 'checkInWorkingSiteQuest']);
    });
});
