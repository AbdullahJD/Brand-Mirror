<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderDashboardController extends Controller
{
    public function index()
    {
        $orders = Order::with('items.product')
            ->latest()
            ->paginate(20);

        return response()->json([
            'status' => true,
            'orders' => $orders
        ]);
    }

    public function show(Order $order)
    {
        return response()->json([
            'status' => true,
            'order' => $order->load('items.product')
        ]);
    }

    public function stats()
    {
        return response()->json([
            'total_orders' => Order::count(),
            'pending' => Order::where('status', 'pending')->count(),
            'processing' => Order::where('status', 'processing')->count(),
            'completed' => Order::where('status', 'delivered')->count(),
            'cancelled' => Order::where('status', 'cancelled')->count(),
            'revenue' => Order::where('status', 'delivered')->sum('final_total'),
        ]);
    }
}
