<?php

namespace App\Services;

use App\Models\Favorite;

class FavoriteService
{
    private function getSessionId(): string
    {
        $sessionId = request()->header('X-CART-SESSION');

        if (!$sessionId) {
            throw new \Exception('Missing X-CART-SESSION header');
        }

        return $sessionId;
    }

    public function toggle(int $productId): array
    {
        $favorite = Favorite::where('session_id', $this->getSessionId())
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
            'session_id' => $this->getSessionId(),
            'product_id' => $productId,
        ]);

        return [
            'is_favorite' => true,
            'message' => 'Added to favorites'
        ];
    }

    public function list()
    {
        return Favorite::with('product')
            ->where('session_id', $this->getSessionId())
            ->latest()
            ->get();
    }

    public function remove(int $productId): void
    {
        Favorite::where('session_id', $this->getSessionId())
            ->where('product_id', $productId)
            ->delete();
    }
}