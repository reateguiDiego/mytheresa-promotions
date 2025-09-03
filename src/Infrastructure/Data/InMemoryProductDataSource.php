<?php

namespace App\Infrastructure\Data;

use App\Domain\Product;

final class InMemoryProductDataSource implements ProductDataSourceInterface
{
    /** @param list<Product> $products */
    public function __construct(private readonly array $products) {}

    /** @return list<Product> */
    public function all(): array
    {
        return $this->products;
    }
}
