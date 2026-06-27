<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reviews = Review::with('product')->latest()->paginate(20);

        return view('Dashboard.Pages.Review.index', compact('reviews'));
    }

    public function approve(Review $review)
    {
        $review->update([
            'is_approved' => true
        ]);

        return back()->with('updated', 'Review Approved');
    }

    public function destroy(Review $review)
    {
        $review->delete();

        return back()->with('deleted', 'Review Deleted');
    }
}
