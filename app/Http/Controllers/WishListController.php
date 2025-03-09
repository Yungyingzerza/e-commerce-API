<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Product;

class WishListController extends Controller
{

    public function getWhishListByProduct($product_id)
    {
        // Get user
        $user = auth('sanctum')->user();

        // Check if user is authenticated
        if (!$user) {
            return response()->json([
                'message' => 'Unauthorized. Please log in.',
            ], 401);
        }

        // Get  a wishlist
        $wishlist = $user->wishLists()->where('product_id', $product_id)->first();

        return response()->json(
            $wishlist
        , 200);
    }

    public function index(Request $request)
    {
        // Get all wishlist
        $user = auth('sanctum')->user();

        // Check if user is authenticated
        if (!$user) {
            return response()->json([
                'message' => 'Unauthorized. Please log in.',
            ], 401);
        }

        // Get all wishlist with product details and product image
        $wishlist = $user->wishLists()->with('product', 'product.productImage')->orderBy('created_at', 'desc')->get();

        return response()->json([
            'message' => 'Successfully retrieved all wishlist.',
            'wishlist' => $wishlist
        ], 200);
    }
    public function wishlist(Request $request)
    {
        // Order a product
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

        // check if already in wishlist
        $wishlist = $user->wishLists()->where('product_id', $validated['product_id'])->first();
        if ($wishlist) {
            return response()->json([
                'message' => 'Product already in wishlist.',
                'wishlist' => $wishlist
            ], 200);
        }

        // create the product
        try {
            $wishlist = $user->wishLists()->create([
                'product_id' => $validated['product_id'],
            ]);
            return response()->json([
                'message' => 'wishlist created Successfully.',
                'wishlist' => $wishlist
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Internal server error, failed to create wishlist.',
                'error' => $e->getMessage(), // Debugging: Show actual error
            ], 501);
        }
    }

    public function update(Request $request, $id)
    {
        // Update an existing order
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
            $wishlist = $user->wishLists()->findOrFail($id);
            $wishlist->update([
                'product_id' => $validated['product_id'],
            ]);
            return response()->json([
                'message' => 'wishlist updated Successfully.',
                'wishlist' => $wishlist
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Internal server error, failed to create wishlist.',
                'error' => $e->getMessage(), // Debugging: Show actual error
            ], 501);
        }
    }

    public function destroy(Request $request, $id)
    {
        // Delete an wishlist
        $user = auth('sanctum')->user();

        // Check if user is authenticated
        if (!$user) {
            return response()->json([
                'message' => 'Unauthorized. Please log in.',
            ], 401);
        }

        // create the product
        try {
            $wishlist = $user->wishLists()->findOrFail($id);

            if (!$wishlist) {
                return response()->json([
                    'message' => 'wishlist not found.',
                ], 404);
            }

            $wishlist->delete();
            return response()->json([
                'message' => 'wishlist deleted Successfully.'
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Internal server error, failed to delete wishlist.',
                'error' => $e->getMessage(), // Debugging: Show actual error
            ], 501);
        }
    }
}
