<?php

use App\Http\Controllers\AuthController\AuthController;
use App\Http\Controllers\CategoryController\CategoryController;
use App\Http\Controllers\OrderController\OrderController;
use App\Http\Controllers\OrderController\OrderItemController;
use App\Http\Controllers\ProductController\ProductController;
use App\Http\Controllers\StoreController\StoreController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');



Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::prefix('categories')->group(function () {
    Route::get('/', [CategoryController::class, 'index']);
    Route::get('/get-all-category', [CategoryController::class, 'getCategoryByProduct']);
    Route::post('/', [CategoryController::class, 'store']);
});

Route::prefix('product')->group(function () {
    Route::get('/', [ProductController::class, 'index']);
    Route::get('/get-product', [ProductController::class, 'getProductsByCategory']);
    Route::post('/{storeId}/{categoryId}', [ProductController::class, 'store']);
    Route::get('/{product}', [ProductController::class, 'show']);
    Route::put('/{product}', [ProductController::class, 'update']);
    Route::delete('/{product}', [ProductController::class, 'destroy']);


});

Route::prefix('stores')->group(function () {
    Route::get('/{userId}', [StoreController::class, 'index']);
    Route::post('/', [StoreController::class, 'store'])->middleware('auth:api');;
    Route::get('/{id}', [StoreController::class, 'show']);
    Route::delete('/{id}', [StoreController::class, 'destroy']);
});

Route::prefix('orders')->group(function () {
    Route::get('/', [OrderController::class, 'index']);
    Route::post('/', [OrderController::class, 'store']);
    Route::get('/{order}', [OrderController::class, 'show']);
    Route::put('/{order}', [OrderController::class, 'update']);
    Route::delete('/{order}', [OrderController::class, 'destroy']);

    Route::prefix('{order}/items')->group(function () {
        Route::get('/', [OrderItemController::class, 'index']);
        Route::post('/', [OrderItemController::class, 'store']);
    });
});

Route::delete('/orderItems/{orderItem}', [OrderItemController::class, 'destroy']);
