<?php

declare(strict_types=1);

namespace App\Services;

use App\Dto\BestSellersRequestDto;
use App\Interfaces\Cache as CacheRepository;
use App\Interfaces\Logging;

class BestSellersService
{
    public function __construct(
        protected CacheRepository $cache,
        protected Logging $logger
    ) {}

    public function fetchData(BestSellersRequestDto $dto): mixed
    {
        // log service call
        $this->logger->info('BestSellersService->fetchData call');

        $cacheKey = $this->generateCacheKey($dto);

        if ($this->cache->has($cacheKey)) {
            return $this->cache->get($cacheKey);
        }

        $data = ['API Data'];

        // the following construction to cope with the phpstan level 10
        $ttl = is_numeric(config('bestsellers.cacheTtl'))
            ? intval(config('bestsellers.cacheTtl')) : 3600;
        $this->cache->put($cacheKey, $data, $ttl);

        return $data;
    }

    private function generateCacheKey(BestSellersRequestDto $dto): string
    {
        $value = config('bestsellers.cachePrefix');
        $prefix = is_string($value) ? $value : '';

        return $prefix.md5(serialize($dto->toArray()));
    }
}
