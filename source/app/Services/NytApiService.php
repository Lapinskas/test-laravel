<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/** @codeCoverageIgnore */
class NytApiService
{
    public function __construct(
        protected Http $http,
        protected Cache $cache,
        protected Log $log
    ) {}
}
