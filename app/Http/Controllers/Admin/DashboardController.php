<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Counts
        $productsCount = Product::count();
        $ordersCount   = Order::count();
        $usersCount    = User::count();

        // Revenue (only delivered orders)
        $revenue = Order::where('status', 'delivered')->sum('final_total');

        // Latest orders
        $latestOrders = Order::with('customer')
            ->latest()
            ->take(5)
            ->get();

        // Status counts for chart
        $statusCounts = Order::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status');

        // Revenue per month (delivered only)
        $revenuePerMonth = Order::where('status', 'delivered')
            ->select(
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
                DB::raw('SUM(final_total) as total')
            )
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month');

        return view('Dashboard.dashboard', compact(
            'productsCount',
            'ordersCount',
            'usersCount',
            'revenue',
            'latestOrders',
            'statusCounts',
            'revenuePerMonth'
        ));
    }
}
