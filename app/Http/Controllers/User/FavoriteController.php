<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\FavoriteService;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function toggle(Request $request, FavoriteService $service) 
    {

        $request->validate([
            'product_id' => 'required|exists:products,id'
        ]);

        return response()->json([
            'status' => true,
            'data' => $service->toggle(
                $request->product_id
            )
        ]);
    }

    public function index(FavoriteService $service) 
    {
        return response()->json([
            'status' => true,
            'favorites' => $service->list()
        ]);
    }

    public function destroy(int $productId, FavoriteService $service) 
    {
        $service->remove($productId);

        return response()->json([
            'status' => true,
            'message' => 'Favorite removed'
        ]);
    }


}
