<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Validator;

class RegisteredUserController extends Controller
{
    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        // Create a validator instance
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
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

        // Create the new user
        try {
            $user = User::create([
                'name' => $validated['name'],
                'surname' => $validated['surname'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Internal server error, failed to create user.',
                'error' => "Dev error",
            ], 500);
        }

        // Trigger the Registered event (optional)
        event(new Registered($user));

        // Return a JSON response with status 201 (Created) and user data
        return response()->json([
            'message' => 'User successfully registered',
            'user' => $user
        ], 201);
    }
}
