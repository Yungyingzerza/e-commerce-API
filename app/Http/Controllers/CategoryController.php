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


    public function update(Request $request, $id) {}

    public function destroy(Request $request, $id) {}

    public function comment(Request $request, $id) {}

    public function order(Request $request, $id) {}
}
