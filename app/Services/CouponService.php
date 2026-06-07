<?php

namespace App\Services;

use App\Models\Coupon;
use Carbon\Carbon;

class CouponService
{
    /**
     * جلب الكوبون
     */
    public function findCoupon(string $code): ?Coupon
    {
        return Coupon::where('code', $code)->first();
    }

    /**
     * التحقق من صلاحية الكوبون
     */
    public function validateCoupon(?Coupon $coupon, float $orderTotal): void
    {
        if (!$coupon) {
            throw new \Exception("Coupon not found");
        }

        if (!$coupon->is_active) {
            throw new \Exception("Coupon is not active");
        }

        $now = Carbon::now();

        if ($coupon->start_at && $now->lt($coupon->start_at)) {
            throw new \Exception("Coupon not started yet");
        }

        if ($coupon->end_at && $now->gt($coupon->end_at)) {
            throw new \Exception("Coupon expired");
        }

        if ($coupon->usage_limit && $coupon->used_count >= $coupon->usage_limit) {
            throw new \Exception("Coupon usage limit reached");
        }

        if ($coupon->min_order_amount && $orderTotal < $coupon->min_order_amount) {
            throw new \Exception("Order does not meet minimum amount");
        }
    }

    /**
     * حساب الخصم
     */
    public function calculateDiscount(Coupon $coupon, float $orderTotal): float
    {
        $discount = 0;

        if ($coupon->type === 'percentage') {
            $discount = ($orderTotal * $coupon->value) / 100;
        }

        if ($coupon->type === 'fixed') {
            $discount = $coupon->value;
        }

        if ($coupon->max_discount && $discount > $coupon->max_discount) {
            $discount = $coupon->max_discount;
        }

        // لا يمكن أن يكون الخصم أكبر من الطلب
        if ($discount > $orderTotal) {
            $discount = $orderTotal;
        }

        return round($discount, 2);
    }

    /**
     * زيادة عدد الاستخدام
     */
    public function applyCoupon(Coupon $coupon): void
    {
        $coupon->increment('used_count');
    }

    /**
     * العملية الكاملة
     */
    public function process(string $code, float $orderTotal): array
    {
        $coupon = $this->findCoupon($code);

        $this->validateCoupon($coupon, $orderTotal);

        $discount = $this->calculateDiscount($coupon, $orderTotal);

        // مهم: تسجيل الاستخدام
        $this->applyCoupon($coupon);

        return [
            'coupon' => $coupon,
            'discount' => $discount,
            'final_total' => $orderTotal - $discount
        ];
    }
}