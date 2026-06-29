<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Favorite;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $featuredProducts = Product::where('is_featured', true)
        ->latest()
        ->take(8)
        ->get();

        $recentProducts = Product::latest()
        ->take(8)
        ->get();

        $favoriteIds = [];
        if (auth('customer')->check()) {
            $favoriteIds = Favorite::where('customer_id', auth('customer')->id())
            ->pluck('product_id')
            ->toArray();
        }
        $categories = Category::whereNull('parent_id')
            ->where('status', 1)
            ->withCount(['products' => function ($q) {
                $q->where('status', 1);
            }])
        ->get();

        $banners = Banner::where('position', 'home_slider')
            ->where('status', 1)
            ->latest()
            ->take(4)
        ->get();

        $offerLeft = Banner::where('position', 'offer_left')
        ->where('status', 1)
        ->first();

        $offerRight = Banner::where('position', 'offer_right')
        ->where('status', 1)
        ->first();

        $offerTop = Banner::where('position', 'offer_top')
        ->where('status', 1)
        ->first();

        $offerBottom = Banner::where('position', 'offer_bottom')
        ->where('status', 1)
        ->first();
        
        return view('Store.pages.home', compact(
            'featuredProducts', 
            'recentProducts', 
            'favoriteIds', 
            'categories',
            'banners',
            'offerLeft',
            'offerRight',
            'offerTop',
            'offerBottom',
        ));
    }
}
