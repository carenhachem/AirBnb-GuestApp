<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccomodationController;
use App\Http\Controllers\AccomodationTypeController;
Route::get('/', function () {
    return view('welcome');
});


//Accomodations
Route::get('/accommodations', [AccomodationController::class, 'index'])->name('accomodations.index');
Route::get('/accommodations/{id}', [AccomodationController::class, 'show'])->name('accomodations.show');
Route::post('/filter-accommodations', [AccomodationController::class, 'filterByBounds']);
Route::get('/accommodations/filter-by-bounds', [AccomodationController::class, 'filterByBounds']);

//Types
Route::get('/types', [AccomodationTypeController::class, 'index'])->name('types.index');
Route::get('/types/{id}', [AccomodationTypeController::class, 'show'])->name('types.show');

