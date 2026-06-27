<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\CartService;
use App\Services\CouponService;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function apply(Request $request, CouponService $couponService)
    {
        $request->validate([
            'code' => 'required|string',
        ]);

        try {
            $result = $couponService->process($request->code);

            $cartService = app(CartService::class);
            // IMPORTANT: re-fetch clean cart from DB
            $cart = $cartService->getCart();

            return response()->json([
                'status' => true,
                'message' => 'Coupon applied successfully',
                'discount' => $result['discount'],
                'final_total' => $result['final_total'],
                'cart' => $cart,
                'cart_count' => $cart->items->sum('quantity'),
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }
}