<?php

use App\Http\Controllers\Api\TelegramIntegrationController;
use Illuminate\Support\Facades\Route;

Route::post('/shops/{shopId}/telegram/connect', [TelegramIntegrationController::class, 'connect'])
    ->whereNumber('shopId')
    ->name('shops.telegram.connect');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/shops/{shopId}/telegram/status', [TelegramIntegrationController::class, 'status'])
    ->whereNumber('shopId')
    ->name('shops.telegram.status');
