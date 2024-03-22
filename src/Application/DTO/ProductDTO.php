<?php

namespace Alcoline\Daniel\Application\DTO;

class ProductDTO
{
    public int $id;
    public string $name;
    public string $price;
    public int $stock;

    public function __construct(int $id, string $name, string $price, int $stock)
    {
        $this->id = $id;
        $this->name = $name;
        $this->price = $price;
        $this->stock = $stock;
    }
}