<?php

use App\Containers\PaymentSection\PaymentSystem\UI\API\Controllers\EnotController;
use App\Containers\PaymentSection\PaymentSystem\UI\API\Controllers\PaymentSystemController;
use App\Containers\PaymentSection\PaymentSystem\UI\API\Controllers\XmpayController;
use App\Containers\PaymentSection\PaymentSystem\UI\API\Controllers\FreekassaController;
use App\Containers\PaymentSection\PaymentSystem\UI\API\Controllers\SkinsbackController;
use Illuminate\Support\Facades\Route;


Route::prefix('payment')->as('payment.')->group(function () {
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::post('make', [PaymentSystemController::class, 'make']);
        Route::get('systems-info', [PaymentSystemController::class, 'systemsInfo']);
    });

    Route::post('enot/result', [EnotController::class, 'result']);
    Route::post('xmpay/result', [XmpayController::class, 'result']);
    Route::post('skinsback/result', [SkinsbackController::class, 'result']);
    Route::post('fk/result', [FreekassaController::class, 'result']);
});

