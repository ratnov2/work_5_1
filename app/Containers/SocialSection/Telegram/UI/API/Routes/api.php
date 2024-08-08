<?php

use App\Containers\SocialSection\Telegram\UI\API\Controllers\WebhookController;
use Illuminate\Support\Facades\Route;

Route::any('/webhook/9F8gciXYMLO4dY1Ov74f', [WebhookController::class, 'handle'])->name('telegram.webhook');
