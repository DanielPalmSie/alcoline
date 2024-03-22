<?php

namespace Alcoline\Daniel\Domain\Entity;

use Alcoline\Daniel\Domain\ValueObject\Name;
use Alcoline\Daniel\Domain\ValueObject\Stock;
use Money\Money;

class Product
{
    private int $id;
    private Name $name;
    private Money $price;
    private Stock $stock;

    public function __construct(Name $name, Money $price, Stock $stock)
    {
        $this->name = $name;
        $this->price = $price;
        $this->stock = $stock;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId($id): ?int
    {
        return $this->id = $id;
    }

    public function getName(): Name
    {
        return $this->name;
    }

    public function setName(Name $name): void
    {
        $this->name = $name;
    }

    public function getPrice(): Money
    {
        return $this->price;
    }

    public function setPrice(Money $price): void
    {
        $this->price = $price;
    }

    public function getStock(): Stock
    {
        return $this->stock;
    }

    public function setStock(Stock $stock): void
    {
        $this->stock = $stock;
    }
}