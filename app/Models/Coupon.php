<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'type',
        'value',
        'min_order_amount',
        'max_discount',
        'usage_limit',
        'used_count',
        'start_at',
        'end_at',
        'is_active',
        'is_single_use',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_single_use' => 'boolean',
        'start_at' => 'datetime',
        'end_at' => 'datetime',
    ];

    public function isValid(): bool
    {
        if (!$this->is_active) return false;

        $now = Carbon::now();

        if ($this->start_at && $now->lt($this->start_at)) return false;
        if ($this->end_at && $now->gt($this->end_at)) return false;

        if ($this->usage_limit && $this->used_count >= $this->usage_limit) return false;

        return true;
    }
}
