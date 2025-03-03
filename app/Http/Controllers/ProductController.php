<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductImage;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        // $products = Product::all();

        //get products and their images
        $products = Product::with('productImage')->get();

        return response()->json($products);
    }

    public function store(Request $request)
    {
        $user = auth('sanctum')->user();

        // Check if user is authenticated
        if (!$user) {
            return response()->json([
                'message' => 'Unauthorized. Please log in.',
            ], 401);
        }

        // Validate input
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'numeric', 'min:0'],
            'category_id' => ['required', 'uuid'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        // Retrieve validated data
        $validated = $validator->validated();

        try {
            $category = Category::findOrFail($validated['category_id']);

            // Create product
            $product = $category->product()->create([
                'name' => $validated['name'],
                'description' => $validated['description'],
                'price' => $validated['price'],
                'stock' => $validated['stock'],
                'category_id' => $validated['category_id'],
                'user_id' => $user->id,
            ]);

            return response()->json([
                'message' => 'Product created successfully.',
                'product' => $product
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Internal server error, failed to create product.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    public function update(Request $request, $id)
    {
        $user = auth('sanctum')->user();

        // Check if user is authenticated
        if (!$user) {
            return response()->json([
                'message' => 'Unauthorized. Please log in.',
            ], 401);
        }

        // Store a new product
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'numeric', 'min:0'],
            'category_id' => ['required', 'uuid']
        ]);



        // Check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors() // Show the validation errors
            ], 422); // 422 Unprocessable Entity
        }


        // If validation passes, you can access validated data
        $validated = $validator->validated();


        // create the product
        try {
            $product = Product::findOrFail($id);
            // Check if the authenticated user is the owner of the product
            if ($product->user_id !== $user->id) {
                return response()->json([
                    'message' => 'Forbidden. You do not have permission to update this product.',
                ], 403);
            }
            $product->update([
                'name' => $validated['name'],
                'description' => $validated['description'],
                'price' => $validated['price'],
                'stock' => $validated['stock'],
                'category_id' => $validated['category_id'],
                'user_id' => $user->id,
            ]);
            return response()->json([
                'message' => 'Product updated Successfully.',
                'product' => $product
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Internal server error, failed to create product.',
                'error' => $e->getMessage(), // Debugging: Show actual error
            ], 501);
        }
    }

    public function destroy(Request $request, $id)
    {
        $user = auth('sanctum')->user();

        // Check if user is authenticated
        if (!$user) {
            return response()->json([
                'message' => 'Unauthorized. Please log in.',
            ], 401);
        }
        try {
            // Find product by ID
            $product = Product::findOrFail($id);
            // Check if the authenticated user is the owner of the product
            if ($product->user_id !== $user->id) {
                return response()->json([
                    'message' => 'Forbidden. You do not have permission to update this product.',
                ], 403);
            }
            // Delete the product
            $product->delete();

            // Return a JSON response with status 200 (OK) and success message
            return response()->json([
                'message' => 'Product successfully deleted'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Internal server error, failed to delete product.',
                'error' =>  $e->getMessage(),
            ], 500);
        }
    }

    public function getImage(Request $request)
    {
        try {
            // Find product by ID
            $image = ProductImage::all();

            // Return a JSON response with the product image
            return response()->json([
                'image' => $image
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Internal server error, failed to get product image.',
                'error' =>  $e->getMessage(),
            ], 500);
        }
    }

    public function uploadImage(Request $request)
    {
        // Store a new product
        $validator = Validator::make($request->all(), [
            'image_url' => ['required', 'string', 'max:2048'],
            'product_id' => ['required', 'exists:products,id'],
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors() // Show the validation errors
            ], 422); // 422 Unprocessable Entity
        }

        // If validation passes, you can access validated data
        $validated = $validator->validated();

        try {
            // Find product by ID
            $product = Product::findOrFail($validated['product_id']);
            $image = $product->productImage()->create([
                'image_url' => $validated['image_url'],
                'product_id' => $validated['product_id']
            ]);


            // Return a JSON response with status 200 (OK) and success message
            return response()->json([
                'message' => 'Product image uploaded successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Internal server error, failed to upload product image.',
                'error' =>  $e->getMessage(),
            ], 500);
        }
    }

    public function deleteImage(Request $request, $id)
    {
        try {
            // Find product by ID
            $image = ProductImage::findOrFail($id);

            // Delete the product
            $image->delete();

            // Return a JSON response with status 200 (OK) and success message
            return response()->json([
                'message' => 'Product image successfully deleted'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Internal server error, failed to delete product image.',
                'error' =>  $e->getMessage(),
            ], 500);
        }
    }

    public function updateImage(Request $request, $id)
    {
        // Store a new product
        $validator = Validator::make($request->all(), [
            'image_url' => ['required', 'string', 'max:2048'],
            'product_id' => ['required', 'exists:products,id'],
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors() // Show the validation errors
            ], 422); // 422 Unprocessable Entity
        }

        // If validation passes, you can access validated data
        $validated = $validator->validated();

        try {
            // Find product by ID
            $product = Product::findOrFail($validated['product_id']);
            $image = ProductImage::findOrFail($id);
            $image->update([
                'image_url' => $validated['image_url'],
                'product_id' => $validated['product_id']
            ]);

            // Return a JSON response with status 200 (OK) and success message
            return response()->json([
                'message' => 'Product image updated successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Internal server error, failed to update product image.',
                'error' =>  $e->getMessage(),
            ], 500);
        }
    }

    public function getProductImage(Request $request, $id)
    {
        try {
            // Find product by ID
            $product = Product::findOrFail($id);
            $image = $product->productImage()->get();

            // Return a JSON response with the product image
            return response()->json([
                'image' => $image
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Internal server error, failed to get product image.',
                'error' =>  $e->getMessage(),
            ], 500);
        }
    }
}
