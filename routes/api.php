<?php

use App\Http\Controllers\CategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserAddressController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;

// Route::get('/user', function (Request $request) {
//     if (!auth('sanctum')->check()) {
//         return response()->json([
//             'error' => 'Unauthenticated'
//         ], 403);
//     }
//     return auth('sanctum')->user();
// });

Route::prefix('user')->group(function () {
    Route::get('/', [UserController::class, 'getUser']); // get user
    Route::get('/addresses', [UserAddressController::class, 'index']);  // List all addresses for the user
    Route::post('/addresses', [UserAddressController::class, 'store']); // Create a new address
    Route::put('/addresses/{id}', [UserAddressController::class, 'update']); // Update an existing address
    Route::delete('/addresses/{id}', [UserAddressController::class, 'destroy']); // Delete an address
    Route::put('/balance/{id}', [UserController::class, 'updateBalance']); // Update the balance for the user
});

Route::prefix('product')->group(function () {
    Route::get('/', [ProductController::class, 'index']); // List all products
    Route::post('/', [ProductController::class, 'store']); // Create a new product
    Route::put('/{id}', [ProductController::class, 'update']); // Update an existing product
    Route::delete('/{id}', [ProductController::class, 'destroy']); // Delete a product
    Route::get('/image', [ProductController::class, 'getImage']); // Get a single product
    Route::post('/image', [ProductController::class, 'uploadImage']); // Upload an image for a product
    Route::delete('/image/{id}', [ProductController::class, 'deleteImage']); // Delete an image for a product
    Route::put('/image/{id}', [ProductController::class, 'updateImage']); // Update the stock for a product
    Route::get('/image/{id}', [ProductController::class, 'getProductImage']); // Get a single product
    Route::post('/{id}/comment', [ProductController::class, 'comment']); // Comment on a product
    Route::post('/{id}/order', [ProductController::class, 'order']); // Order a product
});

Route::prefix('category')->group(function () {
    Route::get('/', [CategoryController::class, 'index']); // List all categories
    Route::post('/', [CategoryController::class, 'store']); // Create a new category
    Route::put('/{id}', [CategoryController::class, 'update']); // Update an existing category
    Route::delete('/{id}', [CategoryController::class, 'destroy']); // Delete a category
});

