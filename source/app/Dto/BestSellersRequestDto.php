<?php

declare(strict_types=1);

namespace App\Dto;

use App\Helpers\Getter;

/**
 * DTO for Best Sellers request
 * DTO has already validated and typed properties
 *
 * @property-read ?string $author
 * @property-read ?string $title
 * @property-read ?int $offset
 * @property-read ?array $isbn
 */
class BestSellersRequestDto
{
    use Getter;

    /**
     * @param  ?array{string}  $isbn
     */
    public function __construct(
        protected readonly ?string $author,
        protected readonly ?string $title,
        protected readonly ?int $offset,
        protected readonly ?array $isbn,
    ) {}
}
