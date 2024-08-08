<?php

use App\Containers\Trade\UI\API\Controllers\LiveTradeController;
use Illuminate\Support\Facades\Route;

Route::get('liveTrades', [LiveTradeController::class, 'liveTrades']);
