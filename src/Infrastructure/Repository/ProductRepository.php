<?php

namespace Alcoline\Daniel\Infrastructure\Repository;

use Alcoline\Daniel\Domain\Entity\Product;
use Alcoline\Daniel\Domain\Repository\ProductRepositoryInterface;
use Alcoline\Daniel\Domain\ValueObject\Name;
use Alcoline\Daniel\Domain\ValueObject\Stock;
use Alcoline\Daniel\Infrastructure\Storage\DatabaseConnection;
use Money\Currency;
use Money\Money;

class ProductRepository implements ProductRepositoryInterface
{
    private \PDO $connection;

    public function __construct()
    {
        $this->connection = DatabaseConnection::getInstance()->getConnection();
    }

    public function findById(int $id): ?Product
    {
        $statement = $this->connection->prepare("SELECT * FROM products WHERE id = :id");
        $statement->execute(['id' => $id]);
        $productData = $statement->fetch();

        if ($productData) {
            $priceInCents = (int)($productData['price'] * 100);
            return new Product(
                new Name($productData['name']),
                new Money($priceInCents, new Currency('USD')),
                new Stock((int)$productData['stock'])
            );
        }

        return null;
    }

    public function findByName(Name $name): ?Product
    {
        $statement = $this->connection->prepare("SELECT * FROM products WHERE name = :name");
        $statement->execute(['name' => (string)$name]);
        $productData = $statement->fetch();

        if ($productData) {
            $product = new Product(
                new Name($productData['name']),
                new Money((int)($productData['price'] * 100), new Currency('USD')),
                new Stock((int)$productData['stock'])
            );
            $product->setId($productData['id']);
            return $product;
        }

        return null;
    }

    public function findAll(): array
    {
        $statement = $this->connection->query("SELECT * FROM products");
        $productsData = $statement->fetchAll();

        $products = [];
        foreach ($productsData as $productData) {

            $product = new Product(
                new Name($productData['name']),
                new Money((int)($productData['price'] * 100), new Currency('USD')),
                new Stock((int)$productData['stock'])
            );

            $product->setId($productData['id']);
            $products[] = $product;
        }

        return $products;
    }

    public function save(Product $product): void
    {

        if ($product->getId() !== null && $this->findById($product->getId()) !== null) {

            $statement = $this->connection->prepare("UPDATE products SET name = :name, price = :price, stock = :stock WHERE id = :id");
        } else {

            $statement = $this->connection->prepare("INSERT INTO products (name, price, stock) VALUES (:name, :price, :stock)");
        }

        $data = [
            ':name' => (string)$product->getName(),
            ':price' => $product->getPrice()->getAmount(),
            ':stock' => $product->getStock()->getValue(),
        ];

        if ($product->getId() !== null) {
            $data[':id'] = $product->getId();
        }

        $statement->execute($data);

        if ($product->getId() === null) {
            $product->setId((int)$this->connection->lastInsertId());
        }
    }

    public function remove(Product $product): void
    {
        $statement = $this->connection->prepare("DELETE FROM products WHERE id = :id");
        $statement->execute(['id' => $product->getId()]);
    }
}