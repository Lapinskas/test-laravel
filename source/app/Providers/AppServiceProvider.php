<?php

declare(strict_types=1);

namespace App\Providers;

use App\Interfaces\Cache;
use App\Interfaces\Logging;
use App\Repositories\RedisCacheRepository;
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
        $this->app->bind(Cache::class, RedisCacheRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void {}
}
