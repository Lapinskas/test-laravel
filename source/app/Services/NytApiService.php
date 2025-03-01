<?php

declare(strict_types=1);

namespace App\Services;

use App\Dto\BestSellersRequestDto;
use App\Interfaces\Logging;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class NytApiService
{
    public function __construct(
        protected Http $http,
        protected Cache $cache,
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

        return [];
    }
}
