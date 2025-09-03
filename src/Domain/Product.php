<?php

namespace App\Domain;

final class Product
{
    public function __construct(
        public readonly string $sku,
        public readonly string $name,
        public readonly string $category,
        public readonly int $price
    ) {}
}
