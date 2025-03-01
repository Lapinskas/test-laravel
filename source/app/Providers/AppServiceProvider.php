<?php

declare(strict_types=1);

namespace App\Providers;

use App\Interfaces\Logging;
use App\Services\LaravelLogger;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(Logging::class, LaravelLogger::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void {}
}
