<?php

declare(strict_types=1);

namespace App\Interfaces;

use App\Dto\BestSellersRequestDto as Request;

/**
 * New York Times Bestsellers API interface
 */
interface BestSellersApi
{
    /**
     * @return array<string, mixed>
     */
    public function fetchData(Request $dto): array;
}
