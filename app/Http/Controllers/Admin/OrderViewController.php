<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderViewController extends Controller
{
    
    public function index()
    {
        $orders = Order::with('items.product')->latest()->paginate(20);

        $stats = [
            'total_orders' => Order::count(),
            'pending' => Order::where('status', 'pending')->count(),
            'confirmed' => Order::where('status', 'confirmed')->count(),
            'processing' => Order::where('status', 'processing')->count(),
            'shipped' => Order::where('status', 'shipped')->count(),
            'delivered' => Order::where('status', 'delivered')->count(),
            'cancelled' => Order::where('status', 'cancelled')->count(),
            'revenue' => Order::where('status', 'delivered')->sum('final_total'),
        ];

        // $statusCounts = Order::select('status', DB::raw('count(*) as count'))
        // ->groupBy('status')
        // ->pluck('count', 'status');

        // $revenuePerMonth = Order::where('status', 'delivered')
        //     ->select(
        //         DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
        //         DB::raw('SUM(final_total) as total')
        //     )
        //     ->groupBy('month')
        //     ->orderBy('month')
        //     ->pluck('total', 'month');

        return view('Dashboard.Pages.Orders.index',compact('orders', 'stats'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Order $order)
    {
        $order->load('items.product', 'items.variant');
        return view(
            'Dashboard.Pages.Orders.show',
            ['pageTitle' => 'Order Details'] + compact('order')
        );
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
