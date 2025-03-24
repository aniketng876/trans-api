<?php

namespace App\BO;

use App\DAO\ProductDAO;

class ProductBO
{
    private ProductDAO $productDAO;

    public function __construct(ProductDAO $productDAO)
    {
        $this->productDAO = $productDAO;
    }

    public function getSku(): string
    {
        return $this->productDAO->getSku();
    }

    public function getId(): int
    {
        return $this->productDAO->getId();
    }

    public function getName(): string
    {
        return $this->productDAO->getName();
    }

    public function getDescription(): string
    {
        return $this->productDAO->getDescription();
    }

    public function getPrice(): float
    {
        return $this->productDAO->getPrice();
    }

    public function getCategoryId(): int
    {
        return $this->productDAO->getCategoryId();
    }

    public function applyDiscount(float $discountPercent): void
    {
        $this->productDAO->price -= ($this->productDAO->price * $discountPercent / 100);
    }

    public function formatProductName(): void
    {
        $this->productDAO->name = strtoupper($this->productDAO->name);
    }

    public function getProductDAO(): ProductDAO
    {
        return $this->productDAO;
    }
}
