<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Dto\BestSellersRequestDto as Request;
use App\Interfaces\BestSellersApi;

class NytBestSellersRepository implements BestSellersApi
{
    public function fetchData(Request $dto): array
    {
        return [];
    }
}
