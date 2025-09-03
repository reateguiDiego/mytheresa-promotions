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
        $priceLessThan = $request->query->getInt('priceLessThan') ?: null;

        $payload = $service->listProducts(
            $category ?: null,
            $priceLessThan
        );

        return $this->json(['products' => $payload]);
    }
}
