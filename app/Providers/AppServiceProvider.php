<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Favorite;
use App\Models\Notification;
use App\Services\CartService;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->app->useLangPath(resource_path('lang'));

        View::composer('*', function ($view) {
        
            $cartService = app(CartService::class);
            $cart = $cartService->resolveCart()->load('items');
            $count = $cart->items->sum('quantity');
            $view->with('cartCount', $count);

            if (auth()->check()) {

                $user = auth()->user();

                $notifications = Notification::where('user_id', $user->id)
                    ->latest()
                    ->take(10)
                    ->paginate(20);

                $unreadCount = Notification::where('user_id', $user->id)->where('is_read', false)->count();

                $categories = Category::with(['children.products', 'products'])->get();

                $favoriteIds = [];
                if (auth('customer')->check()) {
                    $favoriteIds = Favorite::where('customer_id', auth('customer')->id())
                        ->pluck('product_id')
                        ->toArray();
                }

                $view->with([
                    'notifications' => $notifications,
                    'unreadCount' => $unreadCount,
                    'categories' => $categories,
                    'favoriteIds' => $favoriteIds,  
                ]);
            }
        });


        View::composer('Store.*', function ($view) {

            $categories = Category::whereNull('parent_id')
                ->where('status', 1)
                ->with([
                    'children' => function ($q) {
                        $q->where('status', 1)
                        ->with([
                            'products' => function ($p) {
                                $p->where('status', 1);
                            }
                        ]);
                    }
                ])
                ->get();

            $view->with('categories', $categories);
        });
    }
}
