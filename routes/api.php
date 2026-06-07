<?php

use App\Http\Controllers\Admin\OrderDashboardController;
use App\Http\Controllers\User\BannerController;
use App\Http\Controllers\User\CartController;
use App\Http\Controllers\User\CheckoutController;
use App\Http\Controllers\User\CouponController;
use App\Http\Controllers\User\FavoriteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::post('/checkout', [CheckoutController::class, 'checkout']);
Route::post('/apply-coupon', [CouponController::class, 'apply']);

Route::post('/cart/add', [CartController::class, 'add']);
Route::get('/cart', [CartController::class, 'cart']);
Route::post('/cart/update', [CartController::class, 'update']);
Route::post('/cart/remove', [CartController::class, 'remove']);

Route::prefix('admin')->group(function () {

    Route::get('/orders', [OrderDashboardController::class, 'index']);
    Route::get('/orders/{order}', [OrderDashboardController::class, 'show']);
    Route::get('/orders-stats', [OrderDashboardController::class, 'stats']);

    Route::get('/banners', [BannerController::class, 'index']);
});

Route::post('/favorites/toggle', [FavoriteController::class, 'toggle']);
Route::get('/favorites', [FavoriteController::class, 'index']);
Route::delete('/favorites/{productId}', [FavoriteController::class, 'destroy']);
