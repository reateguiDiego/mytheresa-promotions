<?php

namespace App\Controller;

use App\Application\ProductService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class ProductController extends AbstractController
{
    #[Route('/products', name: 'products_list', methods: ['GET'])]
    public function list(Request $request, ProductService $service): Response
    {
        $category = $request->query->get('category');
        $value = $request->query->get('priceLessThan');
        
        if ($value !== null && (!is_numeric($value) || (int)$value < 0)) {
            return $this->json(['error' => 'Invalid priceLessThan'], Response::HTTP_BAD_REQUEST);
        }
        
        $priceLessThan = $value !== null ? (int)$value : null;

        $payload = $service->listProducts(
            $category ?: null,
            $priceLessThan
        );

        return $this->json(['products' => $payload]);
    }
}
