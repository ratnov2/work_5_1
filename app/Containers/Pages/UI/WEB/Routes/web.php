<?php

use App\Containers\Pages\UI\WEB\Controllers\PagesController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PagesController::class, 'spa'])->name('spa');
