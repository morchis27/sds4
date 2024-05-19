<?php

use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\CurrencyExchangeRateController;
use Illuminate\Support\Facades\Route;


Route::get('/rate', [CurrencyExchangeRateController::class, 'getExchangeRate']);

Route::post('/subscribe', [SubscriptionController::class, 'subscribe']);
Route::get('email/verify/{id}', [SubscriptionController::class, 'verify'])->name('verification.verify');
