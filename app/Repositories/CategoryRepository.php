<?php

namespace App\Repositories;

use App\DAO\CategoryDAO;
use App\Models\Category;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class CategoryRepository implements CategoryRepositoryInterface
{
    public function getAll(): array
    {
        return Cache::remember('categories_list', now()->addHours(1), function () {
            $query = Category::with('children');
            return $query->paginate(10)->items();
        });
    }

    public function getById(int $id): ?CategoryDAO
    {
        $category = Category::find($id);
        return $category ? new CategoryDAO($category->id, $category->name, $category->parent_category_id) : null;
    }

    /* public function findCategoryById(int $id): ?Category
    {
        return Category::find($id);
    }

    public function createCategory(array $data): Category
    {
        return Category::create($data);
    } */
    
}
