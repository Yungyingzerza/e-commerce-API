<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\DiscountCode;


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
        $orders = $user->orders()->with('product', 'product.productImage', 'userAddress')->orderBy('created_at', 'desc')->get();

        return response()->json([
            'message' => 'Successfully retrieved all orders.',
            'orders' => $orders
        ], 200);
    }
    
    public function order(Request $request)
    {
        // Get User
        $user = auth('sanctum')->user();

        // Check if user is authenticated
        if (!$user) {
            return response()->json([
                'message' => 'Unauthorized. Please log in.',
            ], 401);
        }

        // Store a new product
        $validator = Validator::make($request->all(), [
            'address_id' => ['required', 'uuid'],
            'discount' => ['nullable', 'string'],
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

        //check user has this address
        $address = $user->userAddresses()->where('id', $validated['address_id'])->first();
        if (!$address) {
            return response()->json([
                'message' => 'Address not found'
            ], 404);
        }

        //get all cart items
        $cart = $user->cart()->with('product')->get();

        //if cart is empty
        if ($cart->isEmpty()) {
            return response()->json([
                'message' => 'Cart is empty'
            ], 400);
        }

        //check all items in the cart are in stock
        foreach ($cart as $item) {
            if ($item->product->stock < $item->quantity) {
                return response()->json([
                    'message' => 'Product out of stock',
                    'product' => $item->product,
                    'wanted_quantity' => $item->quantity,
                    'available_quantity' => $item->product->stock
                ], 400);
            }

            // if size is not null
            if ($item->size) {
                if ($item->product->productSize()->where('size', $item->size)->first()->stock < $item->quantity) {
                    return response()->json([
                        'message' => 'Product out of stock',
                        'product' => $item->product,
                        'wanted_quantity' => $item->quantity,
                        'available_quantity' => $item->product->productSize()->where('size', $item->size)->first()->stock
                    ], 400);
                }
            }
        }

        $quantity = $cart->sum('quantity');

        //get discount get
        $discount = DiscountCode::where('code', $validated['discount'] ?? null)->first();

        //calculate the total price
        $totalPrice = 0;
        foreach ($cart as $item) {
            $totalPrice += $item->product->price * $item->quantity;
        }


        //apply discount if it exists for every item in the cart
        if ($discount) {
            $totalPrice -= ($discount->discount * $quantity);
        }

        //check if the user has enough balance
        if ($user->balance < $totalPrice) {
            return response()->json([
                'message' => 'Insufficient balance',
            ], 400);
        }

        //create the order for each item in the cart
        foreach ($cart as $item) {
            $order = $user->orders()->create([
                'product_id' => $item->product_id,
                'address_id' => $validated['address_id'],
                'size' => $item->size,
                'quantity' => $item->quantity,
                'discount' => $discount ? $discount->discount : 0,
                'total_price' => $item->product->price * $item->quantity
            ]);
        }

        //update the user balance
        $user->balance -= $totalPrice;
        $user->save();

        //update the owner of the product balance
        foreach ($cart as $item) {
            $owner_user_id = $item->product->user_id;
            $owner = User::where('id', $owner_user_id)->first();
            $owner->balance += $item->product->price * $item->quantity;
            $owner->save();
        }

        //update product stock
        foreach ($cart as $item) {
            $item->product->stock -= $item->quantity;
            $item->product->save();

            // if size is not null
            if ($item->size) {
                $productSize = $item->product->productSize()->where('size', $item->size)->first();
            
                if ($productSize) {
                    $productSize->decrement('stock', $item->quantity);
                }
            }
        }

        //delete all items in the cart
        $user->cart()->delete();

        return response()->json([
            'message' => 'Order created successfully',
        ], 201);


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
