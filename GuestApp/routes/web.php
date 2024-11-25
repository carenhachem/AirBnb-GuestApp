<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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


