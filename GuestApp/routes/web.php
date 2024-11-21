<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route::apiResource('user',AuthController::class);
// Route::get('/signup', [AuthController::class, 'create'])->name('user.create');
// Route::post('/signup', [AuthController::class, 'store'])->name('user.store');   