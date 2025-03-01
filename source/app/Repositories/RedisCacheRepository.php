<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Interfaces\Cache as CacheInterface;
use Illuminate\Support\Facades\Cache;
use Psr\SimpleCache\InvalidArgumentException;

class RedisCacheRepository implements CacheInterface
{
    /**
     * Get data from cache by key.
     *
     * @return array<mixed,mixed>|null
     *
     * @throws InvalidArgumentException
     */
    public function get(string $key): ?array
    {
        $encoded = Cache::store('redis')->get($key);
        if (! is_string($encoded)) {
            return null;
        }

        $decoded = json_decode($encoded, true);

        return is_array($decoded) ? $decoded : null;
    }

    public function put(string $key, array $value, int $ttl): void
    {
        $encoded = json_encode($value, JSON_UNESCAPED_UNICODE);
        Cache::store('redis')->put($key, $encoded, $ttl);
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
