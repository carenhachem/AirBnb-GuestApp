<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentGatewayController;


Route::get('/', function () {
    return view('welcome');
});

