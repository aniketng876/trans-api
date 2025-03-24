<?php
namespace App\Services;

use App\BO\CategoryBO;
use App\Models\Category;
use App\Repositories\CategoryRepository;
use Illuminate\Database\Eloquent\Collection;

class CategoryService
{
    protected CategoryRepository $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function getAllCategories(): Array
    {
        return $this->categoryRepository->getAll();
    }

    /* public function getCategoryById(int $id): ?Category
    {
        return $this->categoryRepository->findCategoryById($id);
    }

    public function createCategory(CategoryBO $categoryBO): Category
    {
        return $this->categoryRepository->createCategory($categoryBO->toArray());
    } */
}
