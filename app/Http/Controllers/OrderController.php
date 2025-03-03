<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        // Get all orders
        $user = auth('sanctum')->user();

        // Check if user is authenticated
        if (!$user) {
            return response()->json([
                'message' => 'Unauthorized. Please log in.',
            ], 401);
        }

        // Get all orders
        $orders = $user->orders()->get();

        return response()->json([
            'message' => 'Successfully retrieved all orders.',
            'orders' => $orders
        ], 200);
    }
    public function order(Request $request)
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
            'quantity' => ['required', 'integer', 'min:1'],
            'total_price' => ['required', 'numeric', 'min:0']
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
            $order = $user->orders()->create([
                'product_id' => $validated['product_id'],
                'quantity' => $validated['quantity'],
                'total_price' => $validated['total_price'],
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
            'quantity' => ['required', 'integer', 'min:1'],
            'total_price' => ['required', 'numeric', 'min:0']
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
            $order = $user->orders()->findOrFail($id);
            $order->update([
                'product_id' => $validated['product_id'],
                'quantity' => $validated['quantity'],
                'total_price' => $validated['total_price'],
            ]);
            return response()->json([
                'message' => 'Order updated Successfully.',
                'order' => $order
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Internal server error, failed to create order.',
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

        // Store a new product
        $validator = Validator::make($request->all(), [
            'product_id' => ['required', 'uuid'],
            'quantity' => ['required', 'integer', 'min:1'],
            'total_price' => ['required', 'numeric', 'min:0']
        ]);

        // create the product
        try {
            $order = $user->orders()->findOrFail($id);
            $order->delete();
            return response()->json([
                'message' => 'Order deleted Successfully.',
                'order' => $order
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Internal server error, failed to create order.',
                'error' => $e->getMessage(), // Debugging: Show actual error
            ], 501);
        }
    }
}
