<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentGatewayController;


Route::get('/', function () {
    return view('welcome');
});

// Route::get('/home', function () {
//     return view('home');
// })->middleware(['auth'])->name('home');

Route::get('/home', function () {
    return view('home');
});

// Route::apiResource('user',AuthController::class);
// Route::get('/signup', [AuthController::class, 'create'])->name('user.create');
// Route::post('/signup', [AuthController::class, 'store'])->name('user.store');   

Route::get('auth/google', [AuthController::class, 'redirectToGoogle'])->name('google-auth');
Route::get('auth/google/call-back', [AuthController::class, 'callbackGoogle']);

Route::get('login/facebook', [AuthController::class, 'redirectToFacebook'])->name('login.facebook');
Route::get('login/facebook/callback', [AuthController::class, 'handleFacebookCallback']);
