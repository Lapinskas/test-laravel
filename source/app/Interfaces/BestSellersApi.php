<?php

declare(strict_types=1);

namespace App\Interfaces;

use App\Dto\BestSellersRequestDto as Request;
use App\Exceptions\BestSellersApi as ApiException;

/**
 * New York Times Bestsellers API interface
 */
interface BestSellersApi
{
    /**
     * @return array<string, mixed>
     *
     * @throws ApiException
     */
    public function fetchData(Request $dto): array;
}
