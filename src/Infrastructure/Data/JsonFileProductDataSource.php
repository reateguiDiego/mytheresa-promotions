<?php

namespace App\Infrastructure\Data;

use App\Domain\Product;

final class JsonFileProductDataSource implements ProductDataSourceInterface
{
    public function __construct(
        private readonly string $jsonPath
    ) {}

    /** @return list<Product> */
    public function all(): array
    {
        $raw = file_get_contents($this->jsonPath);
        if ($raw === false) {
            return [];
        }

        $data = json_decode($raw, true, 512, JSON_THROW_ON_ERROR);
        $items = $data['products'] ?? [];

        $products = [];
        foreach ($items as $p) {
            $products[] = new Product(
                sku: (string) $p['sku'],
                name: (string) $p['name'],
                category: (string) $p['category'],
                price: (int) $p['price']
            );
        }

        return $products;
    }
}
