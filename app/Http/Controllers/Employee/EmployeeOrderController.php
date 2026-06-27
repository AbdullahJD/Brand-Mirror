<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Order;
use App\Models\User;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeeOrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('customer')->latest();

        // فلترة الحالة
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        return view('employee.orders.index', [
            'orders' => $query->paginate(15),
            'status' => $request->status
        ]);
    }

    public function updateStatus(Request $request, Order $order)
    {
        
        $request->validate([
            'status' => 'required|in:pending,confirmed,processing,shipped,delivered,cancelled',
        ]);

        /**
         *  Workflow Protection (مهم جداً)
         */
        $allowedTransitions = [
            'pending'    => ['confirmed', 'cancelled'],
            'confirmed'  => ['processing', 'cancelled'],
            'processing' => ['shipped', 'cancelled'],
            'shipped'    => ['delivered'],
            'delivered'  => [],
            'cancelled'  => [],
        ];

        $current = $order->status;
        $new = $request->status;

        if (!in_array($new, $allowedTransitions[$current])) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid status transition'
            ], 422);
        }

        $order->update([
            'status' => $new
        ]);

        // Activity Log
        ActivityLog::create([
            'order_id'   => $order->id,
            'customer_id'    => Auth::id(),
            'action'     => 'status_updated',
            'description'=> "Order status changed from $current to $new",
            'old_value'  => $current,
            'new_value'  => $new,
        ]);
        $admins = User::where('role', 'admin')->get();

        foreach ($admins as $admin) {
            app(NotificationService::class)->send(
                $admin->id,
                'update',
                'Order Updated',
                "Order #{$order->id} changed",
                ['order_id' => $order->id]
            );
        }

        return response()->json([
            'success' => true,
            'message' => 'Order updated successfully',
            'status'  => $order->status
        ]);
    }

    public function show(Order $order)
    {
        $order->load(['customer', 'activityLogs.customer']);

        return view('employee.orders.show', compact('order'));
    }
}
