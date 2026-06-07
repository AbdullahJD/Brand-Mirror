<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function add(Request $request, CartService $cartService)
    {
        $request->validate([
            'product_id' => 'required|integer',
            'product_variant_id' => 'nullable|integer',
            'quantity' => 'nullable|integer|min:1',
        ]);

        $item = $cartService->addToCart(
            $request->product_id,
            $request->product_variant_id,
            $request->quantity ?? 1
        );

        return response()->json([
            'status' => true,
            'message' => 'Added to cart',
            'data' => $item
        ]);
    }

    public function cart(CartService $cartService)
    {
        return response()->json([
            'status' => true,
            'cart' => $cartService->getCartDetails()
        ]);
    }

    public function update(Request $request, CartService $cartService)
    {
        $request->validate([
            'item_id' => 'required|integer',
            'quantity' => 'required|integer|min:0',
        ]);

        $item = $cartService->updateQuantity(
            $request->item_id,
            $request->quantity
        );

        return response()->json([
            'status' => true,
            'data' => $item
        ]);
    }

    public function remove(Request $request, CartService $cartService)
    {
        $request->validate([
            'item_id' => 'required|integer',
        ]);

        $cartService->removeItem($request->item_id);

        return response()->json([
            'status' => true,
            'message' => 'Item removed'
        ]);
    }
}
