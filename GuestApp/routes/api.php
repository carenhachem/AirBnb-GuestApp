<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::apiResource('user',AuthController::class);
Route::get('signup', [AuthController::class, 'create'])->name('user.create');
Route::post('signup', [AuthController::class, 'store'])->name('user.store');   

// Route::middleware('auth:sanctum')->group(function () {
// Route::apiResource('user', AuthController::class);

// // Authenticated route to retrieve the current user
// Route::get('/user', function (Request $request) {
//     return $request->user();
// });
// });