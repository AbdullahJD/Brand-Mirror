<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Services\CartService;
use App\Services\NotificationService;
use App\Services\OrderService;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index(CartService $cartService)
    {
        $cart = $cartService->getCart();

        return view('Store.pages.checkout', compact('cart'));
    }

    public function checkout(Request $request, OrderService $orderService)
    {
        $request->validate([
            'name' => 'required|string',
            'phone' => 'required|string',
            'address' => 'required|string',
            'coupon_code' => 'nullable|string'
        ]);

        if ($request->expectsJson()) {
            $request->validate([
                'name' => 'required|string',
                'phone' => 'required|string',
                'address' => 'required|string',
                'coupon_code' => 'nullable|string',
            ]);
        }

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
            "Order {$order->order_number} was created"
        );

        // دعم الويب
        if ($request->expectsJson()) {
            return response()->json([
                'status' => true,
                'order_id' => $order->id,
                'order_number' => $order->order_number ?? ('ORD-' . $order->id),
                'final_total' => $order->final_total,
            ]);
        }

        return redirect()
            ->route('store.checkout.success', $order->id)
            ->with('success', __('messages.flash_order_created'));
    }
}
