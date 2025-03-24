<?php

namespace App\Repositories\Contracts;

use App\DAO\CategoryDAO;

interface CategoryRepositoryInterface
{
    public function getById(int $id): ?CategoryDAO;
    public function getAll(): array;
}
