<?php

namespace Alcoline\Daniel\Domain\Repository;

use Alcoline\Daniel\Domain\Entity\Product;
use Alcoline\Daniel\Domain\ValueObject\Name;

interface ProductRepositoryInterface
{
    public function findById(int $id): ?Product;

    public function findByName(Name $name): ?Product;

    public function findAll(): array;

    public function save(Product $product): void;

    public function remove(Product $product): void;
}