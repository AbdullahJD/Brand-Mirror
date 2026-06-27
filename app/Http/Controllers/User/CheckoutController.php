<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\NotificationService;
use App\Services\OrderService;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function checkout(Request $request, OrderService $orderService)
    {
        $request->validate([
            'name' => 'required|string',
            'phone' => 'required|string',
            'address' => 'required|string',
            'coupon_code' => 'nullable|string'
        ]);

        $order = $orderService->createOrderFromCart(
            [
                'name' => $request->name,
                'phone' => $request->phone,
                'address' => $request->address,
            ],
            $request->coupon_code
        );

        app(NotificationService::class)->notifyRoles(
            ['admin'],
            'order',
            'New order Created',
            "Order {$order->name} was created"
        );

        return response()->json([
            'status' => true,
            'message' => 'Order created from cart successfully',
            'order_id' => $order->id,
            'order_number' => $order->order_number,
            'final_total' => $order->final_total,
        ]);
    }
}