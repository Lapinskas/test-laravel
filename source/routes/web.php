<?php

declare(strict_types=1);

use App\Http\Controllers\Api\BestSellersController;
use Illuminate\Support\Facades\Route;
use Illuminate\View\View;

Route::get('/', function (): View {
    return view('welcome');
});

Route::prefix('api/v1.0')->group(function (): void {
    Route::get('/best-sellers', [BestSellersController::class, 'index']);
});
