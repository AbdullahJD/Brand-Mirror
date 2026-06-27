<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Cart;
use App\Models\Product;
use App\Events\OrderCreated;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderService
{
    protected CouponService $couponService;

    public function __construct(CouponService $couponService)
    {
        $this->couponService = $couponService;
    }

    public function createOrderFromCart(array $customerData, ?string $couponCode = null): Order
    {
        return DB::transaction(function () use ($customerData, $couponCode) {
            $cart = $this->getUserCart();
            $cartItems = $cart->items()->with('product')->get();

            if ($cartItems->isEmpty()) {
                throw new \Exception("Cart is empty");
            }

            $this->validateStock($cartItems);

            $total = $cartItems->sum('subtotal');

            $discount = 0;
            $coupon = null;

            if ($couponCode) {
                $coupon = $this->couponService->findCoupon($couponCode);

                if (!$coupon) {
                    throw new \Exception('Invalid coupon code');
                }

                $this->couponService->validateCoupon($coupon, $total);

                $discount = $this->couponService->calculateDiscount($coupon, $total);
            }
            
            $shipping = 5;
            $finalTotal = $total - $discount;

            //  أهم تعديل هنا
            $orderData = [
                'customer_name' => $customerData['name'],
                'phone' => $customerData['phone'],
                'address' => $customerData['address'],
                'order_number' => $this->generateOrderNumber(),
                'total' => $total,
                'discount_amount' => $discount,
                'final_total' => $finalTotal,
                'coupon_id' => $coupon?->id,
                'status' => 'pending',
            ];

            //  ربط ذكي User OR Guest
            $customer = auth('customer')->user();
            if ($customer) {
                $orderData['customer_id'] = $customer->id;
            } else {
                $orderData['session_id'] = $cart->session_id
                    ?? request()->cookie('cart_session')
                    ?? request()->header('X-CART-SESSION');
            }

            $order = Order::create($orderData);

            foreach ($cartItems as $item) {
                $order->items()->create([
                    'product_id' => $item->product_id,
                    'product_variant_id' => $item->product_variant_id,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                    'subtotal' => $item->subtotal,
                ]);
            }

            $this->reduceStockFromCart($cartItems);

            if ($coupon) {
                $this->couponService->applyCoupon($coupon);
            }

            $this->clearCart($cart);

            event(new OrderCreated($order));

            return $order;
        });
    }

    private function getUserCart(): Cart
    {
        // USER (customer)
        $customer = auth('customer')->user();

        if ($customer) {
            return Cart::firstOrCreate([
                'customer_id' => $customer->id
            ]);
        }

        // GUEST
        $sessionId = request()->header('X-CART-SESSION')
            ?? request()->cookie('cart_session');

        if (!$sessionId) {
            throw new \Exception('Cart session header missing');
        }

        return Cart::firstOrCreate([
            'session_id' => $sessionId
        ]);
    }

    private function validateStock($cartItems): void
    {
        foreach ($cartItems as $item) {
            $product = Product::find($item->product_id);

            if (!$product) {
                throw new \Exception("Product not found");
            }

            if ($product->stock < $item->quantity) {
                throw new \Exception("Out of stock: " . $product->name);
            }
        }
    }

    private function reduceStockFromCart($cartItems): void
    {
        foreach ($cartItems as $item) {
            $product = Product::where('id', $item->product_id)
                ->lockForUpdate()
                ->first();

            if ($product) {
                $product->decrement('stock', $item->quantity);
            }
        }
    }

    private function clearCart(Cart $cart): void
    {
        $cart->items()->delete();
    }

    private function generateOrderNumber(): string
    {
        return 'ORD-' . now()->format('YmdHis') . '-' . strtoupper(Str::random(5));
    }
}