<?php

declare(strict_types=1);

namespace App\Dto;

use App\Helpers\Getter;

/**
 * Strongly-typed DTO for Best Sellers request
 * DTO contains already validated and typed properties
 *
 * @property-read ?string $author
 * @property-read ?string $title
 * @property-read ?int $offset
 * @property-read ?array{string} $isbn
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

    public function toArray(): array
    {
        return [
            'author' => $this->author,
            'title' => $this->title,
            'offset' => $this->offset,
            'isbn' => $this->isbn,
        ];
    }
}
