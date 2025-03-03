<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Product;

class WishListController extends Controller
{
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

        // Get all wishlist
        $wishlist = $user->wishLists()->get();

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

        // create the product
        try {
            $wishlist = $user->wishLists()->create([
                'product_id' => $validated['product_id'],
            ]);
            return response()->json([
                'message' => 'wishlist created Successfully.',
                'product' => $wishlist
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
            $wishlist->delete();
            return response()->json([
                'message' => 'wishlist deleted Successfully.',
                'wishlist' => $wishlist
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Internal server error, failed to create wishlist.',
                'error' => $e->getMessage(), // Debugging: Show actual error
            ], 501);
        }
    }
}
