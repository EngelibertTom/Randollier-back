<?php

namespace App\Controller\Api;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

final class ProductController extends AbstractController
{
    #[Route('/api/products', name: 'api_products_list', methods: ['GET'])]
    public function list(ProductRepository $productRepository): JsonResponse
    {
        return $this->json($productRepository->findAll(), 200, [], ['groups' => 'product:list']);
    }

    #[Route('/api/products/featured', name: 'api_products_featured', methods: ['GET'])]
    public function featured(ProductRepository $productRepository): JsonResponse
    {
        return $this->json(
            $productRepository->findBy(['isFeatured' => true, 'isActive' => true]),
            200, [], ['groups' => 'product:list']
        );
    }

    #[Route('/api/products/{id}', name: 'api_products_show', methods: ['GET'])]
    public function show(Product $product): JsonResponse
    {
        return $this->json($product, 200, [], ['groups' => 'product:show']);
    }
}
