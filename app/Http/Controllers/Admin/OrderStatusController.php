<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderStatusController extends Controller
{
    /**
     * تغيير حالة الطلب
     */
    public function updateStatus(Request $request, $id)
    {
        // 1. validation
        $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled'
        ]);

        // 2. جلب الطلب
        $order = Order::findOrFail($id);

        // 3. التحقق من صحة الانتقال ( هنا مكانه الصحيح)
        if (!$this->canChangeStatus($order->status, $request->status)) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid status transition'
            ], 400);
        }

        // 4. تحديث الحالة
        $order->update([
            'status' => $request->status
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Order status updated successfully',
            'order_status' => $order->status
        ]);
    }

    private function canChangeStatus($current, $new): bool
    {
        $flow = [
            'pending' => ['processing', 'cancelled'],
            'processing' => ['completed', 'cancelled'],
            'completed' => [],
            'cancelled' => []
        ];

        return in_array($new, $flow[$current] ?? []);
    }
}
