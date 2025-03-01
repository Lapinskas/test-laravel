<?php

declare(strict_types=1);

namespace App\Interfaces;

use App\Dto\BestSellersRequestDto as Request;
use App\Dto\BestSellersResponseDto as Response;

/**
 * New York Times Bestsellers API interface
 */
interface BestSellersApi
{
    public function fetchData(Request $dto): Response;
}
