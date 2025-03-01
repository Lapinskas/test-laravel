<?php

declare(strict_types=1);

namespace App\Interfaces;

/**
 * New York Times API interface
 */
interface BestSellersApi
{
    /**
     * @param  array{string,mixed}|array{}  $context
     */
    public function info(string $message, array $context = []): void;
}
