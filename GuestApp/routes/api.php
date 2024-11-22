<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentGatewayController;


// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::get('/payment', [PaymentGatewayController::class, 'showPaymentPage'])->name('payment.show');
Route::post('/payment/store',[PaymentGatewayController::class, 'store'])->name('payment.store');