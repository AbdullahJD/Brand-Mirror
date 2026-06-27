<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Product;
use App\Events\OrderStatusUpdated;
use Illuminate\Support\Facades\DB;

class OrderStatusService
{
    /**
     * الحالات المسموحة
     */
    private array $allowedStatuses = [
        'pending',
        'confirmed',
        'processing',
        'shipped',
        'delivered',
        'cancelled'
    ];

    /**
     * تغيير حالة الطلب (MAIN METHOD)
     */
    public function changeStatus(Order $order, string $newStatus): Order
    {
        return DB::transaction(function () use ($order, $newStatus) {

            $newStatus = strtolower($newStatus);

            if (!in_array($newStatus, $this->allowedStatuses)) {
                throw new \Exception("Invalid status");
            }

            // validate transition
            $this->validateTransition($order->status, $newStatus);

            $oldStatus = $order->status;

            $order->update([
                'status' => $newStatus
            ]);

            /**
             * ❗ مهم جدًا:
             * إذا الطلب تم إلغاؤه → رجّع المخزون
             */
            if ($newStatus === 'cancelled') {
                $this->restoreStock($order);
            }

            //  Event (Realtime + hooks)
            event(new OrderStatusUpdated($order, $oldStatus, $newStatus));

            return $order;
        });
    }

    /**
     * قواعد انتقال الحالات
     */
    private function validateTransition(string $current, string $new): void
    {
        $flow = [
            'pending' => ['confirmed', 'cancelled'],
            'confirmed' => ['processing', 'cancelled'],
            'processing' => ['shipped', 'cancelled'],
            'shipped' => ['delivered', 'cancelled'],
            'delivered' => [],
            'cancelled' => []
        ];

        if (!in_array($new, $flow[$current] ?? [])) {
            throw new \Exception("Invalid status transition from $current to $new");
        }
    }

    /**
     * Restore stock عند الإلغاء
     */
    private function restoreStock(Order $order): void
    {
        foreach ($order->items as $item) {

            $product = Product::find($item->product_id);

            if (!$product) {
                continue;
            }

            $product->increment('stock', $item->quantity);
        }
    }

    /**
     * Label للعرض في الداشبورد
     */
    public function getStatusLabel(string $status): string
    {
        return match ($status) {
            'pending' => 'Pending',
            'confirmed' => 'Confirmed',
            'processing' => 'Processing',
            'shipped' => 'Shipped',
            'delivered' => 'Delivered',
            'cancelled' => 'Cancelled',
            default => 'Unknown'
        };
    }

    public function markProcessing(Order $order): Order
    {
        return $this->changeStatus($order, 'processing');
    }

    public function markCompleted(Order $order): Order
    {
        return $this->changeStatus($order, 'delivered');
    }

    public function markCancelled(Order $order): Order
    {
        return $this->changeStatus($order, 'cancelled');
    }
}