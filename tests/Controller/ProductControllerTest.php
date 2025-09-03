<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProductControllerTest extends WebTestCase
{
    public function testProductsEndpointReturnsSuccess(): void
    {
        $client = static::createClient();
        $client->request('GET', '/products');

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/json');
        
        $data = json_decode($client->getResponse()->getContent(), true);

        $this->assertArrayHasKey('products', $data);
        $this->assertLessThanOrEqual(5, count($data['products']));
    }

    public function testProductsEndpointFilterByCategory(): void
    {
        $client = static::createClient();
        $client->request('GET', '/products?category=boots');

        $this->assertResponseIsSuccessful();
        $data = json_decode($client->getResponse()->getContent(), true);

        foreach ($data['products'] as $product) {
            $this->assertSame('boots', $product['category']);
        }
    }
}
