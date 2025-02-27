<?php

use App\Http\Controllers\Api\BestSellersController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('api/v1.0')->group(function () {
    Route::get('/best-sellers', [BestSellersController::class, 'index']);
});
