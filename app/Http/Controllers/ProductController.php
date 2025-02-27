<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::all();
        return response()->json($products);
    }

    public function store(Request $request)
    {
        // Store a new product
        // Create a validator instance
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['string'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'numeric', 'min:0'],
            'category_id' => ['required', 'integer', 'exists:categories,id']
        ]);

        // Check if the validation fails
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Bad request, validation failed.',
                'errors' => $validator->errors(),
            ], 400);
        }

        // If validation passes, you can access validated data
        $validated = $validator->validated();

        // create the product
        try {
            $product = Product::create([
                'name' => $validated['name'],
                'description' => $validated['description'],
                'price' => $validated['price'],
                'stock' => $validated['stock'],
                'category_id' => $validated['category_id']
            ]);
            return response()->json([
                'message' => 'Product created successfully.',
                'product' => $product
            ], 201);            
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Internal server error, failed to create product.',
                'error' => "Dev error",
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {

    }

    public function destroy(Request $request, $id)
    {

    }

    public function comment(Request $request, $id)
    {

    }

    public function order(Request $request, $id)
    {

    }
}
