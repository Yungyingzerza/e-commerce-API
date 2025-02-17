<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserAddressController;
use App\Http\Controllers\UserController;

// Route::get('/user', function (Request $request) {
//     if (!auth('sanctum')->check()) {
//         return response()->json([
//             'error' => 'Unauthenticated'
//         ], 403);
//     }
//     return auth('sanctum')->user();
// });

Route::prefix('user')->group(function () {
    Route::get('/addresses', [UserAddressController::class, 'index']);  // List all addresses for the user
    Route::post('/addresses', [UserAddressController::class, 'store']); // Create a new address
    Route::put('/addresses/{id}', [UserAddressController::class, 'update']); // Update an existing address
    Route::delete('/addresses/{id}', [UserAddressController::class, 'destroy']); // Delete an address
    Route::put('/balance/{id}', [UserController::class, 'updateBalance']); // Update the balance for the user
});


