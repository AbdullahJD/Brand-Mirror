<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\ProductVariant;

class CartService
{
    /**
     * جلب أو إنشاء السلة الحالية
     */
    public function getCart(): Cart
    {
        if (auth()->check()) {
            return Cart::firstOrCreate([
                'user_id' => auth()->id()
            ]);
        }

        // API SAFE MODE
        $sessionId = request()->header('X-CART-SESSION');

        if (!$sessionId) {
            throw new \Exception("Missing X-CART-SESSION header");
        }

        return Cart::firstOrCreate([
            'session_id' => $sessionId
        ]);
    }

    /**
     * إضافة منتج للسلة
     */
    public function addToCart(int $productId, ?int $variantId = null, int $quantity = 1): CartItem
    {
        $cart = $this->getCart();

        $product = Product::findOrFail($productId);

        $price = $product->price;

        if ($variantId) {
            $variant = ProductVariant::findOrFail($variantId);
            $price = $variant->price;
        }

        // 🔥 منع التلاعب: السعر دائمًا من السيرفر
        $subtotal = $price * $quantity;

        $item = CartItem::where('cart_id', $cart->id)
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

        return $cart->items()->create([
            'product_id' => $productId,
            'product_variant_id' => $variantId,
            'quantity' => $quantity,
            'price' => $price,
            'subtotal' => $subtotal,
        ]);
    }

    /**
     * تحديث كمية المنتج
     */
    public function updateQuantity(int $itemId, int $quantity): CartItem
    {
        $item = CartItem::findOrFail($itemId);

        if ($quantity <= 0) {
            $item->delete();
            return $item;
        }

        $item->update([
            'quantity' => $quantity,
            'subtotal' => $item->price * $quantity
        ]);

        return $item;
    }

    /**
     * حذف عنصر
     */
    public function removeItem(int $itemId): bool
    {
        return CartItem::where('id', $itemId)->delete();
    }

    /**
     * عرض السلة
     */
    public function getCartDetails(): Cart
    {
        return $this->getCart()->load('items.product', 'items.variant');
    }

    /**
     * حساب إجمالي السلة (Server-side)
     */
    public function getTotal(): float
    {
        return $this->getCart()
            ->items
            ->sum('subtotal');
    }

    /**
     * تفريغ السلة
     */
    public function clearCart(): void
    {
        $this->getCart()->items()->delete();
    }

    /**
     * دمج سلة الضيف مع المستخدم (IMPORTANT)
     */
    public function mergeGuestCartWithUser(): void
    {
        if (!auth()->check()) return;

        $sessionCart = Cart::where('session_id', session()->getId())->first();

        $userCart = Cart::firstOrCreate([
            'user_id' => auth()->id()
        ]);

        if (!$sessionCart) return;

        foreach ($sessionCart->items as $item) {

            $existingItem = $userCart->items()
                ->where('product_id', $item->product_id)
                ->where('product_variant_id', $item->product_variant_id)
                ->first();

            if ($existingItem) {

                $existingItem->increment('quantity', $item->quantity);

                $existingItem->update([
                    'subtotal' => $existingItem->price * $existingItem->quantity
                ]);

            } else {

                $userCart->items()->create([
                    'product_id' => $item->product_id,
                    'product_variant_id' => $item->product_variant_id,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                    'subtotal' => $item->subtotal,
                ]);
            }
        }

        //  تنظيف كامل (مو بس items)
        $sessionCart->items()->delete();
        $sessionCart->delete();
    }
}