<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Review;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function __construct()
    {
    }

    public function store(Request $request, Product $product)
    {
        // Check if user has already reviewed this product
        $existingReview = Review::where('product_id', $product->id)
            ->where('user_id', Auth::id())
            ->first();

        if ($existingReview) {
            return back()->with('error', 'You have already reviewed this product.');
        }

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'title' => 'nullable|string|max:255',
            'review' => 'required|string|min:10',
        ]);

        // Check if user has purchased this product
        $hasPurchased = Order::where('user_id', Auth::id())
            ->whereHas('items', function ($query) use ($product) {
                $query->where('product_id', $product->id);
            })
            ->where('order_status', '!=', 'cancelled')
            ->exists();

        $review = Review::create([
            'product_id' => $product->id,
            'user_id' => Auth::id(),
            'rating' => $validated['rating'],
            'title' => $validated['title'],
            'review' => $validated['review'],
            'is_verified_purchase' => $hasPurchased,
            'is_approved' => false, // Needs admin approval
        ]);

        return back()->with('success', 'Thank you for your review! It will be published after approval.');
    }

    public function myReviews()
    {
        $reviews = Auth::user()->reviews()->with('product.images')->latest()->paginate(10);
        return view('frontend.account.reviews', compact('reviews'));
    }
}
