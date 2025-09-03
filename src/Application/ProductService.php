<?php

namespace App\Application;

use App\Domain\Product;
use App\Infrastructure\Data\ProductDataSourceInterface;

final class ProductService
{
    public function __construct(
        private readonly ProductDataSourceInterface $dataSource
    ) {}

    /**
     * @param string|null $category
     * @param int|null    $priceLessThan
     * @return list<array<string,mixed>>
     */
    public function listProducts(?string $category, ?int $priceLessThan): array
    {
        return [];
    }
}
