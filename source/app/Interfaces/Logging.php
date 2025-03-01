<?php

declare(strict_types=1);

namespace App\Interfaces;

/**
 * Logging interface
 */
interface Logging
{
    /**
     * @param  array{string,mixed}|array{}  $context
     */
    public function info(string $message, array $context = []): void;

    /**
     * @param  array{string,mixed}|array{}  $context
     */
    public function error(string $message, array $context = []): void;
}
