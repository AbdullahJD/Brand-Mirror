<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Favorite;
use App\Models\Product;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function category(Category $category)
    {
        $category->load([
            'children' => function ($q) {
                $q->where('status', 1)
                ->with(['products' => function ($p) {
                    $p->where('status', 1);
                }]);
            },
            'products' => function ($q) {
                $q->where('status', 1);
            }
        ]);

        $categories = Category::with(['children.products', 'products'])
        ->where('status', 1)
        ->get();

        $favoriteIds = [];
        if (auth('customer')->check()) {
            $favoriteIds = Favorite::where('customer_id', auth('customer')->id())
            ->pluck('product_id')
            ->toArray();
        }

        return view('Store.pages.category', compact('category', 'categories', 'favoriteIds'));
    }

    public function search(Request $request)
    {
        $q = $request->get('q');

        $products = Product::where('name', 'like', "%{$q}%")
            ->limit(10)
            ->get();

        $categories = Category::where('name', 'like', "%{$q}%")
            ->limit(10)
            ->get();

        return response()->json([
            'products' => $products,
            'categories' => $categories,
        ]);
    }
}
