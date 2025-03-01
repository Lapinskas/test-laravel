<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Interfaces\Cache as CacheInterface;
use Illuminate\Support\Facades\Cache;
use Psr\SimpleCache\InvalidArgumentException;

class RedisCacheRepository implements CacheInterface
{
    /**
     * @throws InvalidArgumentException
     */
    public function get(string $key): mixed
    {
        return Cache::store('redis')->get($key);
    }

    public function put(string $key, mixed $value, int $ttl): void
    {
        Cache::store('redis')->put($key, $value, $ttl);
    }

    /**
     * @throws InvalidArgumentException
     */
    public function has(string $key): bool
    {
        return Cache::store('redis')->has($key);
    }

    public function forget(string $key): void
    {
        Cache::store('redis')->forget($key);
    }
}
