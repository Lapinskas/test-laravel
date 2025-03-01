<?php

declare(strict_types=1);

namespace App\Services;

use App\Dto\BestSellersRequestDto;
use App\Interfaces\Logging;
use App\Interfaces\Cache as CacheRepository;

class NytApiService
{
    public function __construct(
        protected CacheRepository $cache,
        protected Logging $logger
    ) {}

    /**
     * @return array{}
     *
     * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter
     */
    public function fetchData(BestSellersRequestDto $dto): array
    {
        // log service call
        $this->logger->info('NytApiService->fetchData call');

        $cacheKey = $this->generateCacheKey($dto);

        if ($this->cache->has($cacheKey)) {
            return $this->cache->get($cacheKey);
        }

        $data = ['API Data'];

        $this->cache->put($cacheKey, $data, config('nyt-service.cacheTtl'));

        return $data;
    }

    private function generateCacheKey(BestSellersRequestDto $dto): string
    {
        return config('nyt-service.cacheKey') . md5(serialize($dto->toArray()));
    }
}
