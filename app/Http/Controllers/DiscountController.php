<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DiscountCode;

class DiscountController extends Controller
{
    public function index(Request $request, $discountCode)
    {
        // Get the discount code
        $discount = DiscountCode::where('code', $discountCode)->first();

        // Check if the discount code exists
        if (!$discount) {
            return response()->json([
                'message' => 'Discount code not found.',
            ], 404);
        }

        return response()->json([
            'message' => 'Discount code found.',
            'discount' => $discount
        ], 200);
    }
}
