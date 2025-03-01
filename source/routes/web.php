<?php

declare(strict_types=1);

use App\Http\Controllers\BestSellersController;
use Illuminate\Support\Facades\Route;
use Illuminate\View\View;

Route::get('/', function (): View {
    return view('welcome');
});

Route::prefix('api/v1')->group(function (): void {
    Route::post('/best-sellers', [BestSellersController::class, 'index'])
        ->name('best-sellers.index');
});
