<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentGatewayController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\UserController;
use App\Models\User;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

// Route::get('/payment', [PaymentGatewayController::class, 'showPaymentPage'])->name('payment.show');
// Route::get('/payment/receipt', [PaymentGatewayController::class, 'previewReceipt'])->name('payment.receipt');
// Route::post('/payment/receipt/confirm',[PaymentGatewayController::class, 'confirm'])->name('payment.receipt.confirm');
// Route::post('/payment/receipt/confirm-download',[PaymentGatewayController::class, 'confirmAndDownload'])->name('payment.receipt.confirm-download');

// Route::middleware(['auth:sanctum', 'extractUserId'])->get('/user', function (Request $request) {
//     return response()->json([
//         'userid' => $request->userid,
//     ]);
// });

//Route::apiResource('user',AuthController::class);
// Route::get('signup', [AuthController::class, 'create'])->name('user.create');
// Route::post('signup', [AuthController::class, 'store'])->name('user.store');

// Route::get('login', [AuthController::class, 'createLogin'])->name('user.login');
// Route::post('login', [AuthController::class, 'login'])->name('login');

// Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

// Route::middleware('auth:sanctum')->get('profile', [UserController::class, 'showProfile'])->name('profile');

// Route::middleware('auth:sanctum')->get('/profile/{userId}', [User::class, 'show'])->name('profile');
// Route::middleware(['auth:sanctum', 'extractUserId'])->get('profile', [UserController::class, 'show'])->name('profile');
// Route::get('profile', [UserController::class, 'show'])->name('profile');

// Route::get('/profile/{userid}', [UserController::class, 'showProfile'])->name('profile.show');
// Route::put('/profile/{userid}/change-password', [UserController::class, 'changePassword'])->name('profile.change-password');
// Route::put('/profile/{userid}/update', [UserController::class, 'updateProfile'])->name('profile.update');

// Route::get('/reservations/{userid}', [ReservationController::class, 'index'])->name('booking-history');

// Route::post('refresh-token', [AuthController::class, 'refresh']);



