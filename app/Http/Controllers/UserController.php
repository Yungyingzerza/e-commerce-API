<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    //update profile_url with upload image
    public function updateProfile(Request $request)
    {
        // Check if the user is authenticated using Sanctum
        if (!auth('sanctum')->check()) {
            return response()->json([
                'message' => 'Unauthenticated',
            ], 401); // 401 is more appropriate for unauthenticated requests than 403
        }
    
        // Manually validate
        $validator = Validator::make($request->all(), [
            'profile_url' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:20480',
        ], [
            'profile_url.required' => 'The profile_url field is required.',
            'profile_url.image' => 'The profile_url must be an image.',
            'profile_url.mimes' => 'The profile_url must be a file of type: jpeg, png, jpg, gif, svg.',
            'profile_url.max' => 'The profile_url must be less than 20MB.',
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }
    
        try {
            $user = auth('sanctum')->user();
    
            // Upload the profile image
            $profileUrl = $request->file('profile_url')->store('profiles', 'public');

            // Update the user's profile_url
            $user->profile_url = "https://api.yungying.com/luna/storage/" . $profileUrl;
            
            $user->save();
            
            return response()->json([
                'message' => 'Profile updated successfully',
                'profile_url' => $user->profile_url
            ], 200);
            
        } catch (\Exception $e) {
            \Log::error('Failed to update profile for user ' . $user->id . ': ' . $e->getMessage());
            return response()->json([
                'message' => 'Failed to update profile.',
                'error' => 'Internal server error',
            ], 500);
        }
    }
    

    public function getUser(Request $request)
    {
        if (!auth('sanctum')->check()) {
            return response()->json([
                'error' => 'Unauthenticated'
            ], 403);
        }
        return auth('sanctum')->user();
    }

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

