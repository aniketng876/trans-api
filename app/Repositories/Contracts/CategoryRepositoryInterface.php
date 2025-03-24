<?php

namespace App\Repositories\Contracts;

use App\DAO\CategoryDAO;

interface CategoryRepositoryInterface
{
    public function getById(int $id): ?CategoryDAO;
    public function getAll(): array;
    // public function create(CategoryDAO $categoryDAO): CategoryDAO;
    // public function update(CategoryDAO $categoryDAO, int $id): ?CategoryDAO;
    // public function delete(int $id): bool;
}
