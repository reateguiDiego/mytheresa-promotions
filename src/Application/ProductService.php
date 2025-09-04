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
        $products = $this->dataSource->all();

        // 1. filter by category
        if ($category !== null) {
            $products = array_filter($products, fn(Product $p) => $p->category === $category);
        }

        // 2. filter by priceLessThan (before discounts)
        if ($priceLessThan !== null) {
            $products = array_filter($products, fn(Product $p) => $p->price <= $priceLessThan);
        }

        // 3. apply discounts + transform to payload
        $payloads = array_map([$this, 'applyDiscount'], $products);

        // 4. limit to 5
        return array_slice(array_values($payloads), 0, 5);
    }

    private function applyDiscount(Product $product): array
    {
        $discount = 0;

        if ($product->category === 'boots') {
            $discount = max($discount, 30);
        }

        if ($product->sku === '000003') {
            $discount = max($discount, 15);
        }

        $original = $product->price;
        $final = $original;
        $discountPercentage = null;

        if ($discount > 0) {
            $final = intdiv($original * (100 - $discount), 100);
            $discountPercentage = $discount . '%';
        }

        return [
            'sku' => $product->sku,
            'name' => $product->name,
            'category' => $product->category,
            'price' => [
                'original' => $original,
                'final' => $final,
                'discount_percentage' => $discountPercentage,
                'currency' => 'EUR'
            ]
        ];
    }
}
