<?php

declare(strict_types=1);

namespace App\Helpers;

/**
 * This helper needed to workaround phpstan level 10 treatment
 * of mixed type
 */
class Config
{
    public static function int(string $key, int $default = 0): int
    {
        $value = config($key);

        // the following construction needed to cope with the phpstan level 10
        return is_numeric($value) ? intval($value) : $default;
    }

    public static function string(string $key, string $default = ''): string
    {
        $value = config($key);

        // the following construction needed to cope with the phpstan level 10
        return is_string($value) ? $value : $default;
    }
}
