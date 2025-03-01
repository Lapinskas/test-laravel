<?php

declare(strict_types=1);

namespace App\Services;

use App\Interfaces\Logging;
use Illuminate\Support\Facades\Log;

/**
 * Wrapper around Laravel Log
 */
class LaravelLogger implements Logging
{
    public function info(string $message, array $context = []): void
    {
        Log::info($message, $context);
    }
}
