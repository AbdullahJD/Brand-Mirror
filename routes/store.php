<?php

use App\Http\Controllers\Store\AuthController;
use App\Http\Controllers\User\CartController;
use App\Http\Controllers\Store\CartPageController;
use App\Http\Controllers\Store\CheckoutController;
use App\Http\Controllers\Store\ContactController;
use App\Http\Controllers\Store\HomeController;
use App\Http\Controllers\Store\MyOrderController;
use App\Http\Controllers\Store\OrderController;
use App\Http\Controllers\Store\ReviewController;
use App\Http\Controllers\Store\ShopController;
use App\Http\Controllers\Store\StoreController;
use App\Http\Controllers\User\CouponController;
use App\Http\Controllers\User\FavoriteController;
use Illuminate\Support\Facades\Route;


Route::get('/', [HomeController::class, 'index'])->name('store.home');

// Route::get('/shop', [ShopController::class, 'index'])->name('store.shop');
Route::get('/shop/{category?}', [ShopController::class, 'index'])
    ->name('store.shop');

Route::get('/product/{id}', [ShopController::class, 'show'])->name('store.product');

Route::get('/cart', [CartController::class, 'index'])->name('store.cart');

Route::get('/checkout', [CheckoutController::class, 'index'])->name('store.checkout');

Route::post('/products/{product}/reviews',[ReviewController::class, 'store'])->name('reviews.store');

// صفحات الموقع
Route::get('/carts', [CartPageController::class, 'index'])->name('carts.index');

Route::prefix('api/cart')->group(function () {
    Route::post('/add', [CartController::class, 'add']);
    Route::post('/update', [CartController::class, 'update']);
    Route::post('/remove', [CartController::class, 'remove']);
    Route::get('/', [CartController::class, 'cart']);
});

Route::middleware('guest:customer')->group(function () {

    Route::get('/login', [AuthController::class, 'showLogin'])->name('store.login');
    Route::post('/login', [AuthController::class, 'login'])->name('store.login.post');

    Route::get('/register', [AuthController::class, 'showRegister'])->name('store.register');
    Route::post('/register', [AuthController::class, 'register'])->name('store.register.post');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('store.logout')
    ->middleware('auth:customer');

Route::get('/checkout', [CheckoutController::class, 'index'])->name('store.checkout');
Route::post('/checkout', [CheckoutController::class, 'checkout']);

Route::post('/apply-coupon', [CouponController::class, 'apply'])
    ->name('coupon.apply');

Route::get('/checkout/success/{order}', function ($orderId) {
    $order = \App\Models\Order::findOrFail($orderId);

    return view('Store.pages.checkoutSuccess', compact('order'));
})->name('store.checkout.success');

Route::get('/my-orders/{order:order_number}', [MyOrderController::class, 'show'])
->name('store.orders.show');

Route::get('/track-order', [MyOrderController::class, 'trackForm'])
    ->name('store.track.form');

Route::post('/track-order', [MyOrderController::class, 'track'])
    ->name('store.track.search');



Route::middleware('auth:customer')->group(function () {

    Route::get('/favorites', [FavoriteController::class, 'index'])
    ->name('store.favorites');

    Route::get('/favorites/page', [FavoriteController::class, 'page'])
    ->name('store.favorites.page');

    Route::post('/favorites/toggle/{productId}', [FavoriteController::class, 'toggle'])
    ->name('store.favorites.toggle');

    Route::delete('/favorites/{productId}', [FavoriteController::class, 'destroy'])
    ->name('store.favorites.remove');

    Route::get('/my-orders', [MyOrderController::class, 'index'])
    ->name('store.orders.index');
});


Route::get('/category/{category}', [StoreController::class, 'category'])->name('store.category');

Route::get('/contact', [ContactController::class, 'index'])->name('store.contact');
Route::post('/contact', [ContactController::class, 'send'])->name('store.contact.send');

Route::get('/search', [StoreController::class, 'search'])->name('store.search');