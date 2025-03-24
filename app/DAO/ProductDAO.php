<?php

namespace App\DAO;

class ProductDAO
{
    public int $id;
    public string $name;
    public string $description;
    public float $price;
    public int $category_id;

    public function __construct(int $id, string $name, string $description, float $price, int $category_id)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
        $this->category_id = $category_id;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getCategoryId(): int
    {
        return $this->category_id;
    }
}
