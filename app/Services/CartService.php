<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Support\Str;

class CartService
{
    public function resolveCart(): Cart
    {
        $customer = auth('customer')->user();

        if ($customer) {
            return Cart::firstOrCreate([
                'customer_id' => $customer->id
            ]);
        }

        $sessionId = $this->getSessionId();

        // logger()->info([
        //     'cookie' => request()->cookie('cart_session'),
        //     'session_id' => session()->getId(),
        //     'customer' => auth('customer')->id(),
        // ]);

        return Cart::firstOrCreate([
            'session_id' => $sessionId
        ], [
            'session_id' => $sessionId
        ]);
    }

    private function getSessionId(): string
    {
        $sessionId = request()->cookie('cart_session');

        if (!$sessionId) {
            $sessionId = (string) Str::uuid();

            cookie()->queue(cookie('cart_session', $sessionId, 60 * 24 * 30));
        }

        return $sessionId;
    }

    public function getCart(): Cart
    {
        return $this->resolveCart()->load(['items.product', 'items.variant']);
    }

    /**
     *  المصدر الوحيد للحساب
     */
    public function getSubtotal(): float
    {
        return $this->resolveCart()->items->sum('subtotal');
    }

    public function getTotal(): float
    {
        $subtotal = $this->getSubtotal();
        $shipping = 5;
        return $subtotal + $shipping;
    }

    public function addToCart(int $productId, ?int $variantId = null, int $quantity = 1): CartItem
    {
        $cart = $this->resolveCart();

        $product = Product::findOrFail($productId);

        $price = $product->discount_price ?: $product->price;

        if ($variantId) {
            $variant = ProductVariant::findOrFail($variantId);
            $price = $variant->price;
        }

        $item = $cart->items()
            ->where('product_id', $productId)
            ->where('product_variant_id', $variantId)
            ->first();

        if ($item) {
            $item->increment('quantity', $quantity);
            $item->update([
                'subtotal' => $item->price * $item->quantity
            ]);

            return $item;
        }

        return CartItem::create([
            'cart_id' => $cart->id,
            'product_id' => $productId,
            'product_variant_id' => $variantId,
            'quantity' => $quantity,
            'price' => $price,
            'subtotal' => $price * $quantity,
        ]);
    }

    public function updateQuantity(int $itemId, int $quantity)
    {
        $item = CartItem::findOrFail($itemId);

        if ($quantity <= 0) {
            $item->delete();
            return null;
        }

        $item->update([
            'quantity' => $quantity,
            'subtotal' => $item->price * $quantity, // الآن price = discount_price
        ]);

        return $item;
    }

    public function removeItem(int $itemId): void
    {
        CartItem::findOrFail($itemId)->delete();
    }
}