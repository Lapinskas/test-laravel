<?php

declare(strict_types=1);

namespace App\Providers;

use App\Interfaces\BestSellersApi;
use App\Interfaces\Cache;
use App\Interfaces\Logging;
use App\Repositories\NytBestSellersRepository;
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

        $this->app->bind(
            BestSellersApi::class,
            NytBestSellersRepository::class
        );
        $this->app->bind(
            Cache::class,
            RedisCacheRepository::class
        );
        $this->app->bind(
            Logging::class,
            LaravelLogger::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void {}
}
