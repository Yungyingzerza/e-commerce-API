<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserAddressController extends Controller
{
    // Get all addresses for the authenticated user
    public function index(Request $request)
    {
        // Check if the user is authenticated using Sanctum
        if (!auth('sanctum')->check()) {
            return response()->json([
            'error' => 'Unauthenticated'
            ], 403);
        }

        $user = auth('sanctum')->user();

        return response()->json($user->userAddresses);
    }

    // Store a new address for the authenticated user
    public function store(Request $request)
    {
        // Create a validator instance
        $validator = Validator::make($request->all(), [
            'address' => ['required', 'string', 'max:255'],
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

        // Check if the user is authenticated using Sanctum
        if (!auth('sanctum')->check()) {
            return response()->json([
                'message' => 'Unauthenticated',
            ], 403);
        }

        // If user is authenticated, create the address
        try {
            $user = auth('sanctum')->user();
            $address = $user->userAddresses()->create([
                'address' => $validated['address'],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Internal server error, failed to create address.',
                'error' => "Dev error",
            ], 500);
        }

        // Return a JSON response with status 201 (Created) and address data
        return response()->json([
            'message' => 'Address successfully created',
            'address' => $address
        ], 201);
    }

    // Update an existing address for the authenticated user
    public function update(Request $request, $id)
    {
        // Create a validator instance
        $validator = Validator::make($request->all(), [
            'address' => ['required', 'string', 'max:255'],
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

        // Check if the user is authenticated using Sanctum
        if (!auth('sanctum')->check()) {
            return response()->json([
                'message' => 'Unauthenticated',
            ], 403);
        }

        try {
            $user = auth('sanctum')->user();
            $address = $user->userAddresses()->findOrFail($id);
            $address->update([
                'address' => $validated['address'],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Internal server error, failed to update address.',
                'error' => "Dev error",
            ], 500);
        }

        // Return a JSON response with updated address
        return response()->json([
            'message' => 'Address successfully updated',
            'address' => $address
        ], 200);
    }

    // Delete an address for the authenticated user
    public function destroy($id)
    {
        // Check if the user is authenticated using Sanctum
        if (!auth('sanctum')->check()) {
            return response()->json([
                'message' => 'Unauthenticated',
            ], 403);
        }

        try {
            $user = auth('sanctum')->user();
            $address = $user->userAddresses()->findOrFail($id);
            $address->delete();
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Internal server error, failed to delete address.',
                'error' => "Dev error",
            ], 500);
        }

        // Return a JSON response with status 200 (OK) and success message
        return response()->json([
            'message' => 'Address successfully deleted'
        ], 200);
    }
}
