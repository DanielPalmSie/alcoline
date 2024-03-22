<?php

namespace Alcoline\Daniel\Domain\Repository;

use Alcoline\Daniel\Domain\Entity\Product;
use Alcoline\Daniel\Domain\ValueObject\Name;

interface ProductRepositoryInterface
{
    /**
     * Найти продукт по идентификатору.
     *
     * @param int $id
     * @return Product|null
     */
    public function findById(int $id): ?Product;

    public function findByName(Name $name): ?Product;

    /**
     * Получить все продукты.
     *
     * @return Product[]
     */
    public function findAll(): array;

    /**
     * Сохранить продукт.
     *
     * @param Product $product
     * @return void
     */
    public function save(Product $product): void;

    /**
     * Удалить продукт по идентификатору.
     *
     * @param Product $product
     * @return void
     */
    public function remove(Product $product): void;
}