<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

use App\BO\CategoryBO;
use App\Services\CategoryService;
use App\Http\Requests\CategoryRequest; 

class CategoryController extends Controller
{
    protected CategoryService $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index(): JsonResponse
    {
        $categories = $this->categoryService->getAllCategories();
        return response()->json(['success' => true, 'data' => $categories]);
    }

    /* public function store(CategoryRequest $request): JsonResponse
    {
        $categoryBO = new CategoryBO($request->validated());
        $category = $this->categoryService->createCategory($categoryBO);

        return response()->json(['success' => true, 'data' => $category], 201);
    } */
}
