<?php
namespace App\Services;

use Illuminate\Support\Facades\Cache;

use App\BO\ProductBO;
use App\DAO\ProductDAO;
use App\Repositories\ProductRepository;

class ProductService
{
    protected ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }
    
    public function createProduct(ProductBO $productBO): array
    {
        
        $productDAO = new ProductDAO(
            0,
            $productBO->getName(),
            $productBO->getDescription(),
            $productBO->getPrice(),
            $productBO->getCategoryId()
        );
        Cache::forget('products:category_' . $productDAO->category_id);
        
        $createdProduct = $this->productRepository->create($productDAO);
        return (array) $createdProduct;
    }

    public function updateProduct(ProductBO $productBO, int $id): ?array
    {
        $productDAO = new ProductDAO(
            $id, 
            $productBO->getName(),
            $productBO->getDescription(),
            $productBO->getPrice(),
            $productBO->getCategoryId()
        );

        Cache::forget('products:category_' . $productDAO->category_id);

        $updatedProduct = $this->productRepository->update($productDAO, $id);
        return $updatedProduct ? (array) $updatedProduct : null;
    }

    public function deleteProduct(int $id): bool
    {
        Cache::forget('products_list');

        $product = $this->productRepository->getById($id);
        if (!$product) {
            return false;
        }

        return $this->productRepository->delete($id);
    }

    public function getAllProducts(?int $categoryId, ?string $search): array
    {
        return $this->productRepository->getAll($categoryId, $search);
    }

    public function getProductById(int $id): ?array
    {
        $product = $this->productRepository->getById($id);
        return $product ? (array) $product : null;
    }
    
}
