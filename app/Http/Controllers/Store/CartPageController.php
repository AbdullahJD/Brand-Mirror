<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Services\CartService;
use Illuminate\Http\Request;

class CartPageController extends Controller
{
    public function index(CartService $cartService)
    {
         $cart = $cartService->getCart();

        return view('Store.pages.Cart.index', compact('cart'));
    }
}
