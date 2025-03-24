<?php
namespace App\Repositories\Contracts;

use App\DAO\ProductDAO;

interface ProductRepositoryInterface
{
    public function getById(int $id): ?ProductDAO;
    public function getAll(): array;
    public function create(ProductDAO $productDAO): ProductDAO;
    public function update(ProductDAO $productDAO, int $id): ?ProductDAO;
    public function delete(int $id): bool;

}
