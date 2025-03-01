<?php

declare(strict_types=1);

namespace App\Interfaces;

/**
 * Memory cache interface
 */
interface Cache
{
    /**
     * Get data from cache by key.
     *
     * @return array<mixed,mixed>|null
     */
    public function get(string $key): ?array;

    /**
     * Put data into cache with a TTL.
     *
     * @param  array<string, mixed>  $value
     */
    public function put(string $key, array $value, int $ttl): void;

    /**
     * Check if key exists in cache.
     */
    public function has(string $key): bool;

    /**
     * Remove data from cache by key.
     */
    public function forget(string $key): void;
}
