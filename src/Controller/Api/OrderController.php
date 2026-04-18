<?php

namespace App\Controller\Api;

use App\Repository\OrderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/orders')]
final class OrderController extends AbstractController
{
    #[Route('', name: 'api_orders_list', methods: ['GET'])]
    public function list(OrderRepository $orderRepository): JsonResponse
    {
        /** @var \App\Entity\User $user */
        $user = $this->getUser();

        $orders = array_map(fn($order) => [
            'id'     => $order->getId(),
            'date'   => $order->getCreatedAt()->format('Y-m-d'),
            'status' => $order->getStatus()->value,
            'total'  => (float) $order->getTotal(),
            'items'  => array_map(fn($item) => [
                'productId' => $item->getProduct()?->getId(),
                'name'      => $item->getProductName(),
                'price'     => (float) $item->getUnitPrice(),
                'qty'       => $item->getQuantity(),
                'image'     => $item->getProductImage() ?? '',
            ], $order->getItems()->toArray()),
        ], $orderRepository->findBy(['user' => $user], ['createdAt' => 'DESC']));

        return $this->json($orders);
    }
}
