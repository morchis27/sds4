<?php

use App\Http\Controllers\EmailController;
use App\Http\Controllers\ExchangeController;
use Illuminate\Support\Facades\Route;


Route::get('/rate', [ExchangeController::class, 'getExchangeRate']);

Route::post('/subscribe', [EmailController::class, 'subscribe']);
Route::get('email/verify/{id}', [EmailController::class, 'verify'])->name('verification.verify');
