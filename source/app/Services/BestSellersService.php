<?php

declare(strict_types=1);

namespace App\Services;

use App\Dto\BestSellersRequestDto;
use App\Interfaces\BestSellersApi;
use App\Interfaces\Cache as CacheRepository;
use App\Interfaces\Logging;

class BestSellersService
{
    private int $ttl;

    public function __construct(
        protected BestSellersApi $api,
        protected CacheRepository $cache,
        protected Logging $logger
    ) {
        // the following construction needed to cope with the phpstan level 10
        $this->ttl = is_numeric(config('bestsellers.cacheTtl'))
            ? intval(config('bestsellers.cacheTtl')) : 3600;
    }

    /**
     * @return array<mixed,mixed>
     */
    public function fetchData(BestSellersRequestDto $dto): array
    {
        // log service call
        $this->logger->info('BestSellersService->fetchData call');

        // try to return cached response
        $cacheKey = $this->generateCacheKey($dto);
        $cachedResponse = $this->cache->get($cacheKey);
        if ($cachedResponse !== null) {
            return $cachedResponse;
        }

        // fetch the data from external interface
        $data = $this->api->fetchData($dto);

        // cache results
        $this->cache->put($cacheKey, $data, $this->ttl);

        return $data;
    }

    public function generateCacheKey(BestSellersRequestDto $dto): string
    {
        $value = config('bestsellers.cachePrefix');
        $prefix = is_string($value) ? $value : '';

        return $prefix.md5(serialize($dto->toArray()));
    }
}
