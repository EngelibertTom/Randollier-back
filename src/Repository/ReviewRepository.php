<?php

namespace App\Repository;

use App\Entity\Product;
use App\Entity\Review;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Review>
 */
class ReviewRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Review::class);
    }

    /**
     * @return Review[]
     */
    public function findByProduct(Product $product): array
    {
        return $this->findBy(['product' => $product], ['createdAt' => 'DESC']);
    }

    public function findOneByUserAndProduct(User $user, Product $product): ?Review
    {
        return $this->findOneBy(['user' => $user, 'product' => $product]);
    }
}
