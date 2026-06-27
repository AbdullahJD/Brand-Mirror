<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function show(Order $order)
    {
        abort_if($order->customer_id != auth('customer')->id(), 403);

        $order->load('items.product');

        return view('Store.pages.orders.show', compact('order'));

    }
}
