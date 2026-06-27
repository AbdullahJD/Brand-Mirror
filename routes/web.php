<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\AttributeController;
use App\Http\Controllers\Admin\AttributeValueController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\OrderStatusController;
use App\Http\Controllers\Admin\OrderViewController;
use App\Http\Controllers\Admin\ProductVariantController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ReviewController;

use App\Http\Controllers\Employee\EmployeeController;
use App\Http\Controllers\Employee\EmployeeOrderController;
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {

        Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');

        Route::resource('users', UserController::class);

        Route::resource('categories', CategoryController::class);
        Route::resource('products', ProductController::class);
        Route::resource('attributes', AttributeController::class);
        Route::resource('attribute-values', AttributeValueController::class);
        Route::resource('product-variants', ProductVariantController::class);

        Route::resource('orders', OrderViewController::class);
        Route::resource('banners', BannerController::class);
        Route::resource('coupons', CouponController::class);

        Route::post('/orders/{order}/status', [OrderController::class, 'changeStatus'])
        ->name('orders.changeStatus');

        Route::get('/reviews', [ReviewController::class, 'index'])
        ->name('reviews.index');

        Route::patch('/reviews/{review}/approve', [ReviewController::class, 'approve'])
        ->name('reviews.approve');

        Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])
        ->name('reviews.destroy');
});

/*
|--------------------------------------------------------------------------
| EMPLOYEE ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:employee'])->prefix('employee')->name('employee.')->group(function () {

    Route::get('/', [EmployeeController::class, 'index'])
    ->name('dashboard');
    
    Route::get('/orders', [EmployeeOrderController::class, 'index'])
    ->name('orders.index');

    Route::patch('/orders/{order}/status', [EmployeeOrderController::class, 'updateStatus'])
    ->name('orders.updateStatus');

    Route::get('/orders/{order}', [EmployeeOrderController::class, 'show'])
    ->name('orders.show');


    Route::resource('coupons', CouponController::class);
    Route::patch('/coupons/{coupon}/toggle', [CouponController::class, 'toggle'])
    ->name('coupons.toggle');
});

Route::middleware(['auth'])->get('/dashboard', function () {

    return match (auth()->user()->role) {
        'admin' => redirect()->route('admin.dashboard'),
        'employee' => redirect()->route('employee.dashboard'),
        default => abort(403),
    };

})->name('dashboard');


Route::middleware(['auth'])->group(function () {

    Route::get('/notifications', [NotificationController::class, 'index'])
        ->name('notifications.index');

    Route::get('/notifications/read/{id}', [NotificationController::class, 'markAsRead'])
        ->name('notifications.read');

    Route::post('/notifications/read-all', [NotificationController::class, 'markAll'])
        ->name('notifications.readAll');

});
require __DIR__.'/auth.php';
