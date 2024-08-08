<?php
use App\Containers\Development\UI\WEB\Controllers\DevController;
use Illuminate\Support\Facades\Route;

if (app()->environment('local')) {
    Route::get('fake-auth/{id}', [DevController::class, 'fakeAuth']);
}