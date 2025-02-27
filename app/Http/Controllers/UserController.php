<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function updateBalance(Request $request, $id)
    {
        // Check if the user is authenticated using Sanctum
        if (!auth('sanctum')->check()) {
            return response()->json([
                'message' => 'Unauthenticated',
            ], 403);
        }

        // Validate the balance input
        $request->validate([
            'balance' => 'required|numeric|min:0',
        ], [
            'balance.required' => 'The balance field is required.',
            'balance.numeric' => 'The balance must be a number.',
        ]);

        try {
            $user = User::findOrFail($id);

            // Optional: Ensure the authenticated user can update the balance
            if ($user->id !== auth('sanctum')->user()->id) {
                return response()->json([
                    'message' => 'You are not authorized to update this user\'s balance.',
                ], 403);
            }

            // Update the user's balance
            $user->balance = $request->input('balance');
            $user->save();
        } catch (\Exception $e) {
            \Log::error('Failed to update balance for user ' . $id . ': ' . $e->getMessage());
            return response()->json([
                'message' => 'Failed to update balance.',
                'error' => 'Internal server error',
            ], 500);
        }

        return response()->json([
            'message' => 'Balance updated successfully',
            'balance' => $user->balance
        ], 200); // Use 200 OK for successful updates
    }
}

