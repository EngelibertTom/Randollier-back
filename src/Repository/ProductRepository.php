<?php

namespace App\Repository;

use App\Entity\Category;
use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Product>
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function findBySlug(string $slug): ?Product
    {
        return $this->findOneBy(['slug' => $slug, 'isActive' => true]);
    }

    /**
     * @return Product[]
     */
    public function findActiveByCategory(Category $category): array
    {
        return $this->findBy(['category' => $category, 'isActive' => true]);
    }

    /**
     * @return Product[]
     */
    public function findActive(): array
    {
        return $this->findBy(['isActive' => true], ['createdAt' => 'DESC']);
    }
}
