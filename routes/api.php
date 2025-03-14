<?php

use App\Http\Controllers\CategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserAddressController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\WishListController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\DiscountController;


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
    Route::post('/profile', [UserController::class, 'updateProfile']); // Update the profile for the user
    Route::get('/addresses', [UserAddressController::class, 'index']);  // List all addresses for the user
    Route::post('/addresses', [UserAddressController::class, 'store']); // Create a new address
    Route::put('/addresses/{id}', [UserAddressController::class, 'update']); // Update an existing address
    Route::delete('/addresses/{id}', [UserAddressController::class, 'destroy']); // Delete an address
    Route::put('/balance/{id}', [UserController::class, 'updateBalance']); // Update the balance for the user
});

Route::prefix('discount')->group(function () {
    Route::get('/{discountCode}', [DiscountController::class, 'index']); // Get a discount code
});

Route::prefix('product')->group(function () {
    Route::get('/', [ProductController::class, 'index']); // List all products
    Route::post('/search', [ProductController::class, 'search']); // List all products
    Route::get('/myproducts', [ProductController::class, 'myProducts']); // List all products
    Route::get('/recent', [ProductController::class, 'getRecent']); // Get a recent products
    Route::get('/image', [ProductController::class, 'getImage']); // Get a single product
    Route::post('/image', [ProductController::class, 'uploadImage']); // Upload an image for a product
    Route::delete('/image/{id}', [ProductController::class, 'deleteImage']); // Delete an image for a product
    Route::put('/image/{id}', [ProductController::class, 'updateImage']); // Update the stock for a product
    Route::get('/image/{id}', [ProductController::class, 'getProductImage']); // Get a single product
    Route::get('/category/{categoryName}', [ProductController::class, 'getProductByCategoryName']); // Get a single product
    Route::get('/{id}', [ProductController::class, 'show']); // List all products
    Route::post('/', [ProductController::class, 'store']); // Create a new product
    Route::post('/{id}', [ProductController::class, 'update']); // Update an existing product
    Route::delete('/{id}', [ProductController::class, 'destroy']); // Delete a product

    Route::get('/size/{id}', [ProductController::class, 'getSize']); // Get a single product
    Route::post('/size', [ProductController::class, 'createSize']); // Upload an image for a product
    Route::delete('/size/{id}', [ProductController::class, 'deleteSize']); // Delete an image for a product
    Route::put('/size/{id}', [ProductController::class, 'updateSize']); // Update the stock for a product
});

Route::prefix('cart')->group(function () {
    Route::get('/', [CartController::class, 'index']); // List all cart items
    Route::post('/', [CartController::class, 'store']); // Add a product to the cart
    Route::get('/count', [CartController::class, 'count']); // Get the total items and total price in the cart
    Route::put('/{id}', [CartController::class, 'update']); // Update an existing cart item
    Route::delete('/{id}', [CartController::class, 'destroy']); // Delete a cart item
});


Route::prefix('order')->group(function () {
    Route::post('/', [OrderController::class, 'order']); // Order a product
    Route::get('/', [OrderController::class, 'index']); // List all orders
    Route::put('/{id}', [OrderController::class, 'update']); // Update an existing order
    Route::delete('/{id}', [OrderController::class, 'destroy']); // Delete an order
});

Route::prefix('comment')->group(function () {
    Route::post('/', [CommentController::class, 'comment']); // Comment a product
    Route::get('/user/{id}', [CommentController::class, 'show']); // Get a single order
    Route::get('/{id}', [CommentController::class, 'index']); // List all Comments  // {id} is id of product
    Route::put('/{id}', [CommentController::class, 'update']); // Update an existing Comment // {id} is id of comment
    Route::delete('/{id}', [CommentController::class, 'destroy']); // Delete an Comment // {id} is id of comment
});

Route::prefix('wishlist')->group(function () {
    Route::post('/', [WishListController::class, 'wishlist']); // Order a product
    Route::get('/', [WishListController::class, 'index']); // List all orders
    Route::get('/product/{product_id}', [WishListController::class, 'getWhishListByProduct']); // Get a single order
    Route::put('/{id}', [WishListController::class, 'update']); // Update an existing order
    Route::delete('/{id}', [WishListController::class, 'destroy']); // Delete an order
});

Route::prefix('category')->group(function () {
    Route::get('/', [CategoryController::class, 'index']); // List all categories
    Route::post('/', [CategoryController::class, 'store']); // Create a new category
    Route::put('/{id}', [CategoryController::class, 'update']); // Update an existing category
    Route::delete('/{id}', [CategoryController::class, 'destroy']); // Delete a category
});

