<?php

namespace App\Tests\Application;

use App\Application\ProductService;
use App\Domain\Product;
use App\Infrastructure\Data\InMemoryProductDataSource;
use PHPUnit\Framework\TestCase;

class ProductServiceTest extends TestCase
{
    public function testBootsHave30PercentDiscount(): void
    {
        $products = [new Product("000001", "Boots", "boots", 10000)];
        $service = new ProductService(new InMemoryProductDataSource($products));

        $result = $service->listProducts(null, null);

        $this->assertSame(7000, $result[0]['price']['final']);
        $this->assertSame("30%", $result[0]['price']['discount_percentage']);
    }

    public function testSku000003Has15PercentDiscount(): void
    {
        $products = [new Product("000003", "Special boots", "boots", 10000)];
        $service = new ProductService(new InMemoryProductDataSource($products));

        $result = $service->listProducts(null, null);

        $this->assertSame(7000, $result[0]['price']['final']);
        $this->assertSame("30%", $result[0]['price']['discount_percentage']);
    }

    public function testFilterByCategory(): void
    {
        $products = [
            new Product("1", "Boots", "boots", 10000),
            new Product("2", "Sneakers", "sneakers", 10000),
        ];
        $service = new ProductService(new InMemoryProductDataSource($products));

        $result = $service->listProducts("boots", null);

        $this->assertCount(1, $result);
        $this->assertSame("boots", $result[0]['category']);
    }

    public function testFilterByPriceLessThan(): void
    {
        $products = [
            new Product("1", "Cheap", "sneakers", 5000),
            new Product("2", "Expensive", "sneakers", 20000),
        ];
        $service = new ProductService(new InMemoryProductDataSource($products));

        $result = $service->listProducts(null, 10000);

        $this->assertCount(1, $result);
        $this->assertSame(5000, $result[0]['price']['original']);
    }

    public function testLimitToFiveResults(): void
    {
        $products = [];
        for ($i = 1; $i <= 10; $i++) {
            $products[] = new Product((string) $i, "Prod $i", "sneakers", 10000);
        }

        $service = new ProductService(new InMemoryProductDataSource($products));
        $result = $service->listProducts(null, null);

        $this->assertCount(5, $result);
    }
}
