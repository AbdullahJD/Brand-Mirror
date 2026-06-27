<?php

use App\Http\Controllers\Admin\OrderDashboardController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\User\BannerController;
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
// Route::post('/apply-coupon', [CouponController::class, 'apply']);

Route::get('/banners', [BannerController::class, 'index']);

// Route::post('/register', [AuthController::class, 'register']);
// Route::post('/login', [AuthController::class, 'login']);


// Route::middleware('auth:sanctum')->group(function () {
//     Route::post('/favorites/toggle', [FavoriteController::class, 'toggle']);
//     Route::get('/favorites', [FavoriteController::class, 'index']);
//     Route::delete('/favorites/{productId}', [FavoriteController::class, 'destroy']);

//     Route::post('/logout', [AuthController::class, 'logout']);

// });
