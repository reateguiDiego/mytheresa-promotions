<?php

namespace App\Infrastructure\Data;

use App\Domain\Product;


interface ProductDataSourceInterface
{
    /** @return list<Product> */
    public function all(): array;
}
