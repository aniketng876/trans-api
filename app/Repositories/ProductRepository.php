<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Cache;

use App\DAO\ProductDAO;
use App\Models\Product;
use App\Repositories\Contracts\ProductRepositoryInterface;

class ProductRepository implements ProductRepositoryInterface
{
    public function getById(int $id): ?ProductDAO
    {
        $product = Product::find($id);
        return $product ? new ProductDAO($product->id, $product->name, $product->description, $product->price, $product->category_id) : null;
    }

    public function getAll(?int $categoryId = null, ?string $search = null): array
    {
        $cacheKey = "products:category_{$categoryId}:search_" . md5($search);
        return Cache::remember($cacheKey, now()->addMinutes(10), function () use ($categoryId, $search) {
            
                $query = Product::query();
            if ($categoryId) {
                $query->where('category_id', $categoryId);
            }

            if (!empty($search)) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('description', 'LIKE', "%{$search}%");
                });
            }
            
            return $query->paginate(10)->items();
        });
    }

    public function create(ProductDAO $productDAO): ProductDAO
    {
        $product = Product::create([
            'name' => $productDAO->name,
            'description' => $productDAO->description,
            'price' => $productDAO->price,
            'category_id' => $productDAO->category_id
        ]);

        return new ProductDAO($product->id, $product->name, $product->description, $product->price, $product->category_id);
    }

    public function update(ProductDAO $productDAO, int $id): ?ProductDAO
    {
        $product = Product::find($id);
        if (!$product) return null;

        $product->update([
            'name' => $productDAO->name,
            'description' => $productDAO->description,
            'price' => $productDAO->price,
            'category_id' => $productDAO->category_id
        ]);

        return new ProductDAO($product->id, $product->name, $product->description, $product->price, $product->category_id);
    }

    public function delete(int $id): bool
    {
        return Product::destroy($id) > 0;
    }
}
