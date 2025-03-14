<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductImage;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\ProductSize;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        //get products and their images ordered by created_at
        $products = Product::with('productImage')->orderBy('created_at', 'desc')->get();

        return response()->json($products);
    }

    public function myProducts(Request $request)
    {
        $user = auth('sanctum')->user();

        // Check if user is authenticated
        if (!$user) {
            return response()->json([
                'message' => 'Unauthorized. Please log in.',
            ], 401);
        }

        //get products and their images ordered by created_at
        $products = Product::with('productImage')->where('user_id', $user->id)->orderBy('created_at', 'desc')->get();

        return response()->json($products);
    }

    public function getRecent(Request $request)
    {
        //get products and their images 10 most recent products
        $products = Product::with('productImage')->orderBy('created_at', 'desc')->take(10)->get();

        return response()->json($products);
    }

    public function getProductByCategoryName(Request $request, $categoryName)
    {
        try {
            // Find category by name
            $category = Category::where('name', $categoryName)->first();
            if (!$category) {
                return response()->json([
                    'message' => 'Category not found',
                ], 404);
            }
            // Find products by category ID and order by created_at most recent
            $products = Product::with('productImage')->where('category_id', $category->id)->orderBy('created_at', 'desc')->get();

            // Return a JSON response with the products
            return response()->json(
                $products
            , 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Internal server error, failed to get products.',
                'error' =>  $e->getMessage(),
            ], 500);
        }
    }
    

    public function show(Request $request, $id)
    {
        try {
            // Find product by ID
            $product = Product::with([
                'productImage',
                'productSize',
                'comments' => function ($query){
                    $query->orderBy('created_at', 'desc');
                },
                'comments.user' => function ($query) {
                    $query->select('id', 'name', 'surname', 'profile_url'); // Ensure 'id' is selected for relationship mapping
                }
            ])->findOrFail($id);

            // Return a JSON response with the product
            return response()->json([
                'product' => $product
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Internal server error, failed to get product.',
                'error' =>  $e->getMessage(),
            ], 500);
        }
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
            "images" => "required|array|min:1",
            "images.*" => "required|image|mimes:jpeg,png,jpg,gif,svg|max:20480"
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

            // Upload product images
            foreach ($request->file('images') as $image) {
                $imageUrl = $image->store('products', 'public');
                $product->productImage()->create([
                    'image_url' => "https://api.yungying.com/luna/storage/" . $imageUrl,
                    'product_id' => $product->id
                ]);
            }

            //return product with images
            $product = Product::with('productImage')->findOrFail($product->id);

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

            //product with images
            $product = Product::with('productImage')->findOrFail($product->id);

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

    public function getSize(Request $request, $id)
    {
        try {
            // Find product by ID
            $product = Product::findOrFail($id);
            $size = $product->productSize()->get();

            // Return a JSON response with the product size
            return response()->json([
                'size' => $size
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Internal server error, failed to get product size.',
                'error' =>  $e->getMessage(),
            ], 500);
        }
    }

    public function createSize(Request $request)
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
            'product_id' => ['required', 'uuid'],
            'size' => ['required', 'string', 'max:2048'],
            'stock' => ['required', 'numeric', 'min:0'],
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
            // Check if the authenticated user is the owner of the product
            if ($product->user_id !== $user->id) {
                return response()->json([
                    'message' => 'Forbidden. You do not have permission to update this product.',
                ], 403);
            }
            $size = $product->productSize()->create([
                'size' => $validated['size'],
                'stock' => $validated['stock'],
                'product_id' => $validated['product_id']
            ]);
            return response()->json([
                'message' => 'Product size created successfully',
                'size' => $size
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Internal server error, failed to create product size.',
                'error' =>  $e->getMessage(),
            ], 500);
        }
    }

    public function updateSize(Request $request, $id)
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
            'size' => ['required', 'string', 'max:2048'],
            'stock' => ['required', 'numeric', 'min:0'],
            'product_id' => ['required', 'uuid'],
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
            // Check if the authenticated user is the owner of the product
            if ($product->user_id !== $user->id) {
                return response()->json([
                    'message' => 'Forbidden. You do not have permission to update this product.',
                ], 403);
            }
            $size = $product->productSize()->findOrFail($id);
            $size->update([
                'size' => $validated['size'],
                'stock' => $validated['stock'],
                'product_id' => $validated['product_id']
            ]);

            // Return a JSON response with status 200 (OK) and success message
            return response()->json([
                'message' => 'Product size updated successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Internal server error, failed to update product size.',
                'error' =>  $e->getMessage(),
            ], 500);
        }
    }

    public function deleteSize(Request $request, $id)
    {
        $user = auth('sanctum')->user();

        // Check if user is authenticated
        if (!$user) {
            return response()->json([
                'message' => 'Unauthorized. Please log in.',
            ], 401);
        }
        try {
            // Find size by ID
            $size = ProductSize::findOrFail($id);
            // Load the product related to this size
            $product = $size->product;

            // Ensure the authenticated user owns the product
            if (!$product || $product->user_id !== $user->id) {
                return response()->json([
                    'message' => 'Forbidden. You do not have permission to delete this size.',
                ], 403);
            }
            $size->delete();

            // Return a JSON response with status 200 (OK) and success message
            return response()->json([
                'message' => 'Product size deleted successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Internal server error, failed to delete product size.',
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
        // Validate input
        $validator = Validator::make($request->all(), [
            'product_id' => ['required', 'exists:products,id'],
            "images" => "required|array|min:1",
            "images.*" => "required|image|mimes:jpeg,png,jpg,gif,svg|max:20480"
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
            

            // Upload product images
            foreach ($request->file('images') as $image) {
                $imageUrl = $image->store('products', 'public');
                $product->productImage()->create([
                    'image_url' => "https://api.yungying.com/luna/storage/" . $imageUrl,
                    'product_id' => $product->id
                ]);
            }

            //return product with images
            $product = Product::with('productImage')->findOrFail($product->id);

            // Return a JSON response with status 200 (OK) and success message
            return response()->json([
                'message' => 'Product image uploaded successfully',
                'product' => $product
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
