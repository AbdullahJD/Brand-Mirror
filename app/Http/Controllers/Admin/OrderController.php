<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\OrderStatusService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function changeStatus(Request $request, Order $order, OrderStatusService $service)
    {
        $request->validate([
            'status' => 'required|string'
        ]);
        try {
            $order = $service->changeStatus($order, $request->status);
        } catch (\Exception $e) {
            return back()->withErrors(['status' => $e->getMessage()
        ]);
        }
        return redirect()
            ->route('orders.show', $order)
            ->with('updated', 'Order status updated successfully');
    }
}
