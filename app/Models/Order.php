<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
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

    // =========================
    // STATUS HELPERS
    // =========================
    public function markAsProcessing(): void
    {
        $this->update(['status' => 'processing']);
    }

    public function markAsCompleted(): void
    {
        $this->update(['status' => 'completed']);
    }

    public function markAsCancelled(): void
    {
        $this->update(['status' => 'cancelled']);
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isEditable(): bool
    {
        return in_array($this->status, ['pending', 'confirmed']);
    }
}
