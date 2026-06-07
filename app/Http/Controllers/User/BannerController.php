<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    public function index()
    {
        return response()->json([
            'status' => true,
            'banners' => Banner::where('status', true)->latest()->get()
        ]);
    }
}
