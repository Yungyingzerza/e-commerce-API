<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class CartController extends Controller
{

    public function count(Request $request)
    {
        // Check if the user is authenticated using Sanctum
        if (!auth('sanctum')->check()) {
            return response()->json([
            'error' => 'Unauthenticated'
            ], 403);
        }

        $user = auth('sanctum')->user();

        // Get the user's cart with product details
        $cartItems = $user->cart()->with('product')->get();

        // Calculate total items and total price
        $totalItems = $cartItems->sum('quantity');
        $totalPrice = $cartItems->sum(function ($cartItem) {
            return $cartItem->quantity * $cartItem->product->price;
        });

        // Return the response
        return response()->json([
            'total_items' => $totalItems,
            'total_price' => $totalPrice
        ]);
    }

    // Get all cart items
    public function index(Request $request)
    {
        // Check if the user is authenticated using Sanctum
        if (!auth('sanctum')->check()) {
            return response()->json([
            'error' => 'Unauthenticated'
            ], 403);
        }

        $user = auth('sanctum')->user();

        return response()->json($user->cart()->with('product', 'product.productImage')->orderBy('created_at', 'desc')->get());
    }

    public function store(Request $request)
    {
        //check if user is authenticated
        if (!auth('sanctum')->check()) {
            return response()->json([
                'error' => 'Unauthenticated'
            ], 403);
        }

        //validate the request
        $validator = Validator::make($request->all(), [
            'product_id' => ['required', 'uuid'],
            'size' => ['nullable', 'string'],
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        //if validation passes, you can access validated data
        $validated = $validator->validated();

        //get the user
        $user = auth('sanctum')->user();

        //check if the product is already in the cart then update the quantity
        $cart = $user->cart()->where('product_id', $validated['product_id'])->first();
        if ($cart) {
            $cart->quantity += $validated['quantity'];
            $cart->save();
            return response()->json([
                'message' => 'Cart updated successfully',
                'cart' => $cart
            ], 200);
        }

        //create the cart
        try {
            $cart = $user->cart()->create([
                'product_id' => $validated['product_id'],
                'size' => $validated['size'] ?? null,
                'quantity' => $validated['quantity'],
            ]);
            return response()->json([
                'message' => 'Product added to cart successfully',
                'cart' => $cart
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Internal server error, failed to add product to cart',
                'error' => $e->getMessage()
            ], 501);
        }

    }

    public function destroy(Request $request, $id)
    {
        //check if user is authenticated
        if (!auth('sanctum')->check()) {
            return response()->json([
                'error' => 'Unauthenticated'
            ], 403);
        }

        //get the user
        $user = auth('sanctum')->user();

        //get the cart item
        $cart = $user->cart()->where('id', $id)->first();

        //check if the cart item exists
        if (!$cart) {
            return response()->json([
                'message' => 'Cart item not found'
            ], 404);
        }

        //delete the cart item
        try {
            $cart->delete();
            return response()->json([
                'message' => 'Cart item deleted successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Internal server error, failed to delete cart item',
                'error' => $e->getMessage()
            ], 501);
        }
    }

    public function update(Request $request, $id)
    {
        //check if user is authenticated
        if (!auth('sanctum')->check()) {
            return response()->json([
                'error' => 'Unauthenticated'
            ], 403);
        }

        //validate the request
        $validator = Validator::make($request->all(), [
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        //if validation passes, you can access validated data
        $validated = $validator->validated();

        //get the user
        $user = auth('sanctum')->user();

        //get the cart item
        $cart = $user->cart()->where('id', $id)->first();

        //check if the cart item exists
        if (!$cart) {
            return response()->json([
                'message' => 'Cart item not found'
            ], 404);
        }

        //update the cart item
        try {
            $cart->quantity = $validated['quantity'];
            $cart->save();
            return response()->json([
                'message' => 'Cart item updated successfully',
                'cart' => $cart
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Internal server error, failed to update cart item',
                'error' => $e->getMessage()
            ], 501);
        }
    }
    
}
