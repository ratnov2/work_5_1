<?php

use App\Containers\Statistics\UI\API\Controllers\StatisticsController;
use Illuminate\Support\Facades\Route;

Route::get('statistics', [StatisticsController::class, 'statistics']);

