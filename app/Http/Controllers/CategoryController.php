<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $category = Category::all();
        return response()->json($category);
    }

    public function store(Request $request)
    {
        // Validate request data
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:255'], // Make description optional
        ]);

        // If validation fails, return errors
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Bad request, validation failed.',
                'errors' => $validator->errors(),
            ], 400);
        }

        // Get validated data
        $validated = $validator->validated();

        try {
            // Create the category directly
            $category = Category::create([
                'name' => $validated['name'],
                'description' => $validated['description'] ?? '', // Default to empty string if null
            ]);

            // Return success response
            return response()->json([
                'message' => 'Category created successfully.',
                'category' => $category
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Internal server error, failed to create category.',
                'error' => $e->getMessage(), // Debugging: Show actual error
            ], 500);
        }
    }


    public function update(Request $request, $id)
    {
        // Validate request data
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:255'], // Make description optional
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Bad request, validation failed.',
                'errors' => $validator->errors(),
            ], 400); // Bad Request
        }

        // If validation passes, access validated data
        $validated = $validator->validated();

        try {
            // Find category by ID
            $category = Category::findOrFail($id);

            // Update category data
            $category->update([
                'name' => $validated['name'],
                'description' => $validated['description'] ?? null, // Set description to null if not provided
            ]);

            // Return success response
            return response()->json([
                'message' => 'Category updated successfully.',
                'category' => $category
            ], 200); // 200 OK for successful update

        } catch (\Exception $e) {
            // If something goes wrong, return error response
            return response()->json([
                'message' => 'Internal server error, failed to update category.',
                'error' => $e->getMessage(), // Show actual error for debugging
            ], 500); // Internal Server Error
        }
    }


    public function destroy(Request $request, $id) {
        try {
            // Find category by ID
            $category = Category::findOrFail($id);

            // Update category data
            $category->delete();
            // Return a JSON response with status 200 (OK) and success message
        return response()->json([
            'message' => 'Address successfully deleted'
        ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Internal server error, failed to delete address.',
                'error' => "Dev error",
            ], 500);
        }

        
    }

    public function comment(Request $request, $id) {}

    public function order(Request $request, $id) {}
}
