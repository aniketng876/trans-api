<?php

// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// use App\Http\Controllers\Api\ProductController;
// use App\Http\Controllers\Api\CategoryController;

use App\Http\Controllers\Api\V1\ProductController as ProductV1Controller;
use App\Http\Controllers\Api\V2\ProductController as ProductV2Controller;

use App\Http\Controllers\Api\V1\CategoryController as CategoryV1Controller;
use App\Http\Controllers\Api\V2\CategoryController as CategoryV2Controller;

// Version 1
Route::prefix('v1')->group(function () {
    Route::prefix('products')->group(function () {
        Route::get('/', [ProductV1Controller::class, 'index']);
        Route::get('/{id}', [ProductV1Controller::class, 'show'])->where('id', '[0-9]+');
        Route::post('/', [ProductV1Controller::class, 'store']);
        Route::put('/{id}', [ProductV1Controller::class, 'update'])->where('id', '[0-9]+');
        Route::delete('/{id}', [ProductV1Controller::class, 'destroy'])->where('id', '[0-9]+');
    });
    Route::get('/categories', [CategoryV1Controller::class, 'index']); 
});

// Version 2
Route::prefix('v2')->group(function () {
    Route::prefix('products')->group(function () {
        Route::get('/', [ProductV2Controller::class, 'index']);
        Route::get('/{id}', [ProductV2Controller::class, 'show'])->where('id', '[0-9]+');
        Route::post('/', [ProductV2Controller::class, 'store']);
        Route::put('/{id}', [ProductV2Controller::class, 'update'])->where('id', '[0-9]+');
        Route::delete('/{id}', [ProductV2Controller::class, 'destroy'])->where('id', '[0-9]+');
    });
    Route::get('/categories', [CategoryV2Controller::class, 'index']); 
});


// Route::get('/categories/{id}', [CategoryController::class, 'show']);
// Route::post('/categories', [CategoryController::class, 'store']);
// Route::put('/categories/{id}', [CategoryController::class, 'update']);
// Route::delete('/categories/{id}', [CategoryController::class, 'destroy']);

// Route::apiResource('categories', CategoryController::class);
// Route::apiResource('products', ProductController::class);