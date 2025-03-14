<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Product;

class CommentController extends Controller
{
    public function index(Request $request, $id)
    {
        // Get all comments
        $comments = Product::findOrFail($id)->comments()->get();

        return response()->json([
            'message' => 'Successfully retrieved all comments.',
            'comments' => $comments
        ], 200);
    }

    //get comment from a user with product id
    public function show(Request $request, $id)
    {
        // Get all comments
        $user = auth('sanctum')->user();
        $comments = $user->comments()->where('product_id', $id)->get();

        return response()->json([
            'message' => 'Successfully retrieved all comments.',
            'comments' => $comments
        ], 200);
    }

    public function comment(Request $request)
    {
        // Comment on a product
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
            'comment' => ['required', 'string'],
            'rating' => ['required', 'integer', 'min:1', 'max:5']
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
            $product = Product::findOrFail($validated['product_id']);
            $order = $product->comments()->create([
                'product_id' => $validated['product_id'],
                'comment' => $validated['comment'],
                'rating' => $validated['rating'],
                'user_id' => $user->id
            ]);
            return response()->json([
                'message' => 'Order created Successfully.',
                'product' => $order
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Internal server error, failed to create order.',
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
            'comment' => ['required', 'string'],
            'rating' => ['required', 'integer', 'min:1', 'max:5']
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
            $comment = $user->comments()->findOrFail($id);
            $comment->update([
                'product_id' => $validated['product_id'],
                'comment' => $validated['comment'],
                'rating' => $validated['rating']
            ]);
            return response()->json([
                'message' => 'comment updated Successfully.',
                'comment' => $comment
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Internal server error, failed to create comment.',
                'error' => $e->getMessage(), // Debugging: Show actual error
            ], 501);
        }
    }

    public function destroy(Request $request, $id)
    {
        // Delete an order
        $user = auth('sanctum')->user();

        // Check if user is authenticated
        if (!$user) {
            return response()->json([
                'message' => 'Unauthorized. Please log in.',
            ], 401);
        }

        // create the product
        try {
            $comment = $user->comments()->findOrFail($id);
            $comment->delete();
            return response()->json([
                'message' => 'Comment deleted Successfully.',
                'Comment' => $comment
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Internal server error, failed to delete Comment.',
                'error' => $e->getMessage(), // Debugging: Show actual error
            ], 501);
        }
    }
}
