<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'customer_name',
        'phone',
        'address',
        'order_number',
        'total',
        'status',
        'coupon_id',
        'discount_amount',
        'final_total',
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function activityLogs()
    {
        return $this->hasMany(ActivityLog::class);
    }

    // =========================
    // STATUS HELPERS
    // =========================

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isEditable(): bool
    {
        return in_array($this->status, ['pending', 'confirmed']);
    }

    public function getCustomerTypeAttribute(): string
    {
        return $this->customer_id  ? 'Customer' : 'Guest';
    }
}
