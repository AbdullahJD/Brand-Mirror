<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct(private CartService $cartService) {}

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer',
            'product_variant_id' => 'nullable|integer',
            'quantity' => 'nullable|integer|min:1',
        ]);

        $this->cartService->addToCart(
            $request->product_id,
            $request->product_variant_id,
            $request->quantity ?? 1
        );

        return response()->json([
            'status' => true,
            'cart' => $this->cartService->getCart(),
            'cart_count' => $this->cartService->getCart()->items->sum('quantity'),
            'total' => $this->cartService->getTotal(),
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'item_id' => 'required|integer',
            'quantity' => 'required|integer|min:0',
        ]);

        $this->cartService->updateQuantity(
            $request->item_id,
            $request->quantity
        );

        return response()->json([
            'status' => true,
            'cart' => $this->cartService->getCart(),
            'cart_count' => $this->cartService->getCart()->items->sum('quantity'),
            'total' => $this->cartService->getTotal(),
        ]);
    }

    public function remove(Request $request)
    {
        $this->cartService->removeItem($request->item_id);

        return response()->json([
            'status' => true,
            'cart' => $this->cartService->getCart(),
            'cart_count' => $this->cartService->getCart()->items->sum('quantity'),
            'total' => $this->cartService->getTotal(),
        ]);
    }
}