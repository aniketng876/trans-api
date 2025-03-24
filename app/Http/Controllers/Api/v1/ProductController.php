<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Exception;

use App\Services\ProductService;
use App\BO\ProductBO;
use App\DAO\ProductDAO;
use App\Http\Requests\ProductRequest;

class ProductController extends Controller
{
    protected ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index(Request $request): JsonResponse
    {
        try {

            $categoryId = $request->query('category_id');
            $search = $request->query('search');

            $products = $this->productService->getAllProducts($categoryId, $search);
            return response()->json(['success' => true, 'data' => $products]);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'error' => 'Failed to fetch products'], 500);
        }
    }

    public function show(int $id): JsonResponse
    {
        try {
            $id = (int) $id;
            $product = $this->productService->getProductById($id);
            return $product ? response()->json(['success' => true, 'data' => $product])
                : response()->json(['success' => false, 'message' => 'Product not found'], 404);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'error' => 'Failed to retrieve product'], 500);
        }
    }

    public function store(ProductRequest $request): JsonResponse
    {
        try {

            $validated = $request->validated();

            // Create a ProductDAO instance
            $productDAO = new ProductDAO(
                0,
                (string) $validated['name'],
                (string) $validated['description'],
                (string) $validated['sku'],
                (float) $validated['price'],
                (int) $validated['category_id']
            );

            $productBO = new ProductBO($productDAO);
            $product = $this->productService->createProduct($productBO);

            return response()->json(['success' => true, 'data' => $product], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['success' => false, 'error' => $e->errors()], 422);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'error' => 'Product creation failed'], 500);
        }
    }

    public function update(ProductRequest $request, int $id): JsonResponse
    {
        try {
            $validated = $request->validated();

            // Create a ProductDAO instance
            $productDAO = new ProductDAO(
                0,
                (string) $validated['name'],
                (string) $validated['description'],
                (string) $validated['sku'],
                (float) $validated['price'],
                (int) $validated['category_id']
            );

            $productBO = new ProductBO($productDAO);
            $product = $this->productService->updateProduct($productBO, $id);

            if (!$product) {
                return response()->json(['error' => 'Product not found'], 404);
            }

            return response()->json(['success' => true, 'data' => $product]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['success' => false, 'error' => $e->errors()], 422);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'error' => 'Product update failed'], 500);
        }
    }

    public function destroy(int $id): JsonResponse
    {
        try {
            $deleted = $this->productService->deleteProduct($id);

            if (!$deleted) {
                return response()->json(['success' => false, 'message' => 'Product not found'], 404);
            }

            return response()->json(['success' => true, 'message' => 'Product deleted successfully']);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'error' => 'Failed to delete product'], 500);
        }
    }
}
