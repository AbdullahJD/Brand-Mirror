<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\FavoriteService;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function toggle(int $productId, FavoriteService $service)
    {
        return response()->json([
            'status' => true,
            'data' => $service->toggle($productId)
        ]);
    }

    public function index(FavoriteService $service) 
    {

        return response()->json([
            'status' => true,
            'favorites' => $service->list()
        ]);
    }

    public function page(FavoriteService $service)
    {
        return view('Store.pages.favorite', [
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
