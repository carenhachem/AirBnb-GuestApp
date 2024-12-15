<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccomodationController;
use App\Http\Controllers\AccomodationTypeController;
use App\Http\Controllers\PaymentGatewayController;
use App\Http\Controllers\ReviewController;


Route::get('auth/google', [AuthController::class, 'redirectToGoogle'])->name('google-auth');
Route::get('auth/google/call-back', [AuthController::class, 'callbackGoogle']);

Route::get('/login', [AuthController::class, 'createLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::get('/signup', [AuthController::class, 'create'])->name('user.create');
Route::post('signup', [AuthController::class, 'store'])->name('user.store');

Route::get('/profile', [UserController::class, 'showProfile'])->middleware('auth')->name('profile');
Route::put('/profile/change-password', [UserController::class, 'changePassword'])->middleware('auth')->name('profile.change-password');
Route::put('/profile/update', [UserController::class, 'updateProfile'])->middleware('auth')->name('profile.update');

Route::post('/reservation/store/{id}', [ReservationController::class, 'store'])->name('reservation.store');
Route::get('/reservations', [ReservationController::class, 'index'])->middleware('auth')->name('booking-history');
Route::get('/wishlist', [ReservationController::class, 'wishlist'])->middleware('auth')->name('wishlist-history');
Route::post('/wishlist/toggle', [AccomodationController::class, 'toggleWishlist'])->name('wishlist.toggle');
Route::delete('/wishlist/{id}', [ReservationController::class, 'destroy'])->middleware('auth')->name('wishlist.destroy');


Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

//Accomodations
Route::get('/', [AccomodationController::class, 'index'])->name('accomodations.index');
Route::get('/accommodations/{id}', [AccomodationController::class, 'show'])->name('accomodations.show');
Route::post('/accomodations/{id}/reserve', [ReservationController::class, 'store'])->name('reservations.store');
Route::post('/filter-accommodations', [AccomodationController::class, 'filterByBounds']);
Route::get('/accommodations/filter-by-bounds', [AccomodationController::class, 'filterByBounds']);

//Types
Route::get('/types', [AccomodationTypeController::class, 'index'])->name('types.index');
Route::get('/types/{id}', [AccomodationTypeController::class, 'show'])->name('types.show');

Route::get('/payment', [PaymentGatewayController::class, 'showPaymentPage'])->middleware('auth')->name('payment.show');
Route::get('/payment/receipt', [PaymentGatewayController::class, 'previewReceipt'])->middleware('auth')->name('payment.receipt');
Route::post('/payment/receipt/confirm',[PaymentGatewayController::class, 'confirm'])->middleware('auth')->name('payment.receipt.confirm');
Route::post('/payment/receipt/confirm-download',[PaymentGatewayController::class, 'confirmAndDownload'])->middleware('auth')->name('payment.receipt.confirm-download');

//Reviews
Route::get('/accommodations/{id}/reviews', [ReviewController::class, 'index'])->name('review.index');
Route::post('/accommodations/{id}/add-review',[ReviewController::class, 'store'])->name('reviews.store')->middleware('auth');