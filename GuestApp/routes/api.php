<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

//for testing middleware:
Route::middleware(['auth:sanctum', 'extractUserId'])->get('/user', function (Request $request) {
    return response()->json([
        'userid' => $request->userid,
    ]);
});

//Route::apiResource('user',AuthController::class);
Route::get('signup', [AuthController::class, 'create'])->name('user.create');
Route::post('signup', [AuthController::class, 'store'])->name('user.store');

Route::get('login', [AuthController::class, 'createLogin'])->name('user.login');
Route::post('login', [AuthController::class, 'login'])->name('login');

Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

// Route::middleware('auth:sanctum')->get('profile', [UserController::class, 'showProfile'])->name('profile');

// Route::middleware('auth:sanctum')->get('/profile/{userId}', [User::class, 'show'])->name('profile');
// Route::middleware(['auth:sanctum', 'extractUserId'])->get('profile', [UserController::class, 'show'])->name('profile');
// Route::get('profile', [UserController::class, 'show'])->name('profile');
// Route::put('change-password/{user}/update', [UserController::class, 'changePassword']);

Route::get('/profile/{userid}', [UserController::class, 'showProfile'])->name('profile.show');
Route::put('/profile/{userid}/change-password', [UserController::class, 'changePassword'])->name('profile.change-password');

Route::post('refresh-token', [AuthController::class, 'refresh']);


// Route::middleware(['auth:sanctum', 'extractUserId'])->group(function () {
//     Route::get('testUserid', [UserController::class, 'testUserid']);
// });
// Route::get('login/google', [AuthController::class, 'redirectToGoogle'])->name('login.google');
// Route::get('login/google/callback', [AuthController::class, 'handleGoogleCallback']);

// Route::get('login/facebook', [AuthController::class, 'redirectToFacebook'])->name('login.facebook');
// Route::get('login/facebook/callback', [AuthController::class, 'handleFacebookCallback']);


// Route::middleware('auth:sanctum')->group(function () {
// Route::apiResource('user', AuthController::class);

// // Authenticated route to retrieve the current user
// Route::get('/user', function (Request $request) {
//     return $request->user();
// });
// });