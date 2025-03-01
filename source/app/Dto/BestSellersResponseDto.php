<?php

declare(strict_types=1);

namespace App\Dto;

use App\Helpers\Getter;
use App\Services\BestSellersService;

/**
 * Strongly-typed DTO for Best Sellers service
 * DTO to return results from service
 *
 * @property-read bool $cached
 * @property-read array<string, mixed>|null $rawResponse
 *
 * @see BestSellersService
 */
class BestSellersResponseDto
{
    use Getter;

    /**
     * @param  array<string, mixed>|null  $rawResponse
     */
    public function __construct(
        protected readonly bool $cached,
        protected readonly ?array $rawResponse,
    ) {}
}
