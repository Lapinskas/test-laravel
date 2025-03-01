<?php

namespace App\Interfaces;

/**
 * Logging interface
 */
interface Logging
{
    public function info(string $message, array $context = []): void;
}
