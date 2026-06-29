<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MyOrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('customer_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('Store.pages.Order.ShowOrder', compact('orders'));
    }

    public function show(Order $order)
    {
        abort_if($order->customer_id != auth('customer')->id(), 403);

        $order->load('items.product');

        return view('Store.pages.orderDetails', compact('order'));
    }

    public function trackForm()
    {
        return view('Store.pages.Order.track');
    }

    public function track(Request $request)
    {
        $request->validate([
            'order_number' => 'required|string',
            'phone' => 'required|string',
        ]);

        $order = Order::where('order_number', $request->order_number)
            ->where('phone', $request->phone)
            ->first();

        if (!$order) {
            return back()->with('error', __('messages.flash_order_not_found'));
        }

        return view('Store.pages.orderDetails', compact('order'));
    }
}
