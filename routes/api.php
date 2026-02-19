<?php

use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\TelegramIntegrationController;
use Illuminate\Support\Facades\Route;

Route::post('/shops/{shopId}/telegram/connect', [TelegramIntegrationController::class, 'connect'])
    ->whereNumber('shopId')
    ->name('shops.telegram.connect');

Route::post('/shops/{shopId}/orders', [OrderController::class, 'store'])
    ->whereNumber('shopId')
    ->name('shops.orders.store');

Route::get('/shops/{shopId}/telegram/status', [TelegramIntegrationController::class, 'status'])
    ->whereNumber('shopId')
    ->name('shops.telegram.status');
