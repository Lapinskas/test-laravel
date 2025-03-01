<?php

declare(strict_types=1);

namespace App\Services;

use App\Dto\BestSellersRequestDto;
use App\Dto\BestSellersResponseDto;
use App\Helpers\Config;
use App\Interfaces\BestSellersApi;
use App\Interfaces\Cache as CacheRepository;
use App\Interfaces\Logging;

class BestSellersService
{
    public function __construct(
        protected BestSellersApi $api,
        protected CacheRepository $cache,
        protected Logging $logger
    ) {}

    /**
     * @throws \App\Exceptions\BestSellersApi
     */
    public function fetchData(
        BestSellersRequestDto $dto
    ): BestSellersResponseDto {
        // log service call
        $this->logger->info('BestSellersService->fetchData call');

        // try to fetch cached response
        $cacheKey = $this->generateCacheKey($dto);
        $cachedResponse = $this->cache->get($cacheKey);

        // return cached response
        if ($cachedResponse !== null) {
            return new BestSellersResponseDto(
                cached: true,
                rawResponse: $cachedResponse
            );
        }

        // fetch the data from external interface
        $data = $this->api->fetchData($dto);

        // cache results
        $this->cache->put(
            key: $cacheKey,
            value: $data,
            ttl: Config::int('bestsellers.cacheTtl', 3600)
        );

        return new BestSellersResponseDto(
            cached: false,
            rawResponse: $data
        );
    }

    public function generateCacheKey(BestSellersRequestDto $dto): string
    {
        $prefix = Config::string('bestsellers.cachePrefix');
        $suffix = md5(serialize($dto->toArray()));

        return $prefix.$suffix;
    }
}
