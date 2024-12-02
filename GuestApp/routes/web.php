<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccomodationController;
use App\Http\Controllers\AccomodationTypeController;
use App\Http\Controllers\PaymentGatewayController;


Route::get('/', function () {
    return view('welcome');
});

// Route::get('/home', function () {
//     return view('home');
// })->middleware(['auth'])->name('home');

Route::get('/home', function () {
    return view('home');
})->name('home');

// Route::apiResource('user',AuthController::class);
// Route::get('/signup', [AuthController::class, 'create'])->name('user.create');
// Route::post('/signup', [AuthController::class, 'store'])->name('user.store');   

Route::get('auth/google', [AuthController::class, 'redirectToGoogle'])->name('google-auth');
Route::get('auth/google/call-back', [AuthController::class, 'callbackGoogle']);

Route::get('login/facebook', [AuthController::class, 'redirectToFacebook'])->name('login.facebook');
Route::get('login/facebook/callback', [AuthController::class, 'handleFacebookCallback']);

Route::get('/login', [AuthController::class, 'createLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::get('/signup', [AuthController::class, 'create'])->name('user.create');
Route::post('signup', [AuthController::class, 'store'])->name('user.store');

Route::get('/profile', [UserController::class, 'showProfile'])->middleware('auth')->name('profile');
Route::put('/profile/change-password', [UserController::class, 'changePassword'])->middleware('auth')->name('profile.change-password');
Route::put('/profile/update', [UserController::class, 'updateProfile'])->middleware('auth')->name('profile.update');


Route::get('/reservations', [ReservationController::class, 'index'])->middleware('auth')->name('booking-history');
Route::get('/wishlist', [ReservationController::class, 'wishlist'])->middleware('auth')->name('wishlist-history');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

//Accomodations
Route::get('/accommodations', [AccomodationController::class, 'index'])->name('accomodations.index');
Route::get('/accommodations/{id}', [AccomodationController::class, 'show'])->name('accomodations.show');
Route::post('/accomodations/{id}/reserve', [ReservationController::class, 'store'])->name('reservations.store');
Route::post('/filter-accommodations', [AccomodationController::class, 'filterByBounds']);
Route::get('/accommodations/filter-by-bounds', [AccomodationController::class, 'filterByBounds']);

//Types
Route::get('/types', [AccomodationTypeController::class, 'index'])->name('types.index');
Route::get('/types/{id}', [AccomodationTypeController::class, 'show'])->name('types.show');

Route::get('/payment', [PaymentGatewayController::class, 'showPaymentPage'])->middleware('auth')->name('payment.show');
Route::get('/payment/receipt', [PaymentGatewayController::class, 'previewReceipt'])->name('payment.receipt');
Route::post('/payment/receipt/confirm',[PaymentGatewayController::class, 'confirm'])->name('payment.receipt.confirm');
Route::post('/payment/receipt/confirm-download',[PaymentGatewayController::class, 'confirmAndDownload'])->name('payment.receipt.confirm-download');