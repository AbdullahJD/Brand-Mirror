<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\CouponService;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function apply(Request $request, CouponService $couponService)
    {
        //  Validation 
        $request->validate([
            'code' => 'required|string',
            'order_total' => 'required|numeric|min:0',
        ]);

        $orderTotal = $request->order_total;

        try {
            // تنفيذ العملية كاملة من Service
            $result = $couponService->process($request->code, $orderTotal);

            return response()->json([
                'status' => true,
                'message' => 'Coupon applied successfully',
                'discount' => $result['discount'],
                'final_total' => $result['final_total'],
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }
}
