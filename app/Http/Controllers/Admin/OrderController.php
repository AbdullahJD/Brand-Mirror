<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\NotificationService;
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

        app(NotificationService::class)->notifyRoles(
            ['admin'],
            'order',
            'New order Status Created',
            "Order {$order->order_number} was Changed Status"
        );
        return redirect()
            ->route('orders.show', $order)
            ->with('updated', 'Order status updated successfully');
    }
}
