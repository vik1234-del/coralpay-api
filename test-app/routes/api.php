<?php

use App\Http\Controllers\PaymentController;

Route::post('/customer-lookup', [PaymentController::class, 'customerLookup']);
Route::post('/vend', [PaymentController::class, 'processPayment']);

