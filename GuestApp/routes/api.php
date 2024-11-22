<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentGatewayController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::get('/payment', [PaymentGatewayController::class, 'showPaymentPage'])->name('payment.show');
Route::post('/payment/store',[PaymentGatewayController::class, 'store'])->name('payment.store');

Route::middleware(['auth:sanctum', 'extractUserId'])->get('/user', function (Request $request) {
    return response()->json([
        'userid' => $request->userid,
    ]);
});

Route::get('signup', [AuthController::class, 'create'])->name('user.create');
Route::post('signup', [AuthController::class, 'store'])->name('user.store');

Route::get('login', [AuthController::class, 'createLogin'])->name('user.login');
Route::post('login', [AuthController::class, 'login'])->name('login');


