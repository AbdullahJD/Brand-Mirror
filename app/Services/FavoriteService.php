<?php

namespace App\Services;

use App\Models\Favorite;

class FavoriteService
{
    public function toggle(int $productId): array
    {
        $customer = auth('customer')->user();

        if (!$customer) {
            throw new \Exception('Unauthorized');
        }

        $favorite = Favorite::where('customer_id', $customer->id)
            ->where('product_id', $productId)
            ->first();

        if ($favorite) {
            $favorite->delete();

            return [
                'is_favorite' => false,
                'message' => 'Removed from favorites'
            ];
        }

        Favorite::create([
            'customer_id' => $customer->id,
            'product_id' => $productId,
        ]);

        return [
            'is_favorite' => true,
            'message' => 'Added to favorites'
        ];
    }

    public function list()
    {
        $customer = auth('customer')->user();

        if (!$customer) {
            throw new \Exception('Unauthorized');
        }

        return Favorite::with('product')
            ->where('customer_id', $customer->id)
            ->latest()
            ->get();
    }

    public function remove(int $productId): void
    {
        $customer = auth('customer')->user();

        if (!$customer) {
            throw new \Exception('Unauthorized');
        }

        Favorite::where('customer_id', $customer->id)
            ->where('product_id', $productId)
            ->delete();
    }
}