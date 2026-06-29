<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Favorite;
use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function show($id)
    {
        $product = Product::with(['images','reviews' => function ($query) {$query->where('is_approved', true);}
        ])->findOrFail($id);

        $reviewsCount = $product->reviews->count();

        $averageRating = round(
            $product->reviews->avg('rating') ?? 0,
            1
        );
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->latest()
            ->take(10)
            ->get();

        return view('Store.pages.product-show', compact(
            'product',
            'reviewsCount',
            'averageRating',
            'relatedProducts',
        ));
    }


    public function index(Request $request)
    {
        $query = Product::where('status', 1);

        // category filter
        if ($request->category) {
            $query->where('category_id', $request->category);
        }

        // price filter
        if ($request->min) {
            $query->where('price', '>=', $request->min);
        }

        if ($request->max) {
            $query->where('price', '<=', $request->max);
        }

        // sorting
        if ($request->sort == 'price_low') {
            $query->orderBy('price', 'asc');
        } elseif ($request->sort == 'price_high') {
            $query->orderBy('price', 'desc');
        } else {
            $query->latest();
        }

        $products = $query->paginate(12)->withQueryString();

        $categories = Category::whereNull('parent_id')
        ->where('status', 1)
        ->withCount(['products' => function ($q) {
            $q->where('status', 1);
        }])
        ->get();

        $favoriteIds = [];
        if (auth('customer')->check()) {
            $favoriteIds = Favorite::where('customer_id', auth('customer')->id())
            ->pluck('product_id')
            ->toArray();
        }

        return view('Store.pages.shop', compact('products', 'categories', 'favoriteIds'));
    }
}
