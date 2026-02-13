<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function __construct()
    {
    }

    /**
     * Display wishlist
     */
    public function index()
    {
        $wishlistItems = Wishlist::with('product.images', 'product.category')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('frontend.wishlist', compact('wishlistItems'));
    }

    /**
     * Add to wishlist
     */
    public function add(Request $request)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Please login to add to wishlist'
            ], 401);
        }

        $request->validate([
            'product_id' => 'required|exists:products,id'
        ]);

        $wishlist = Wishlist::firstOrCreate([
            'user_id' => Auth::id(),
            'product_id' => $request->product_id
        ]);

        $wishlistCount = Wishlist::where('user_id', Auth::id())->count();

        if ($wishlist->wasRecentlyCreated) {
            return response()->json([
                'success' => true,
                'message' => 'Product added to wishlist!',
                'wishlist_count' => $wishlistCount,
                'in_wishlist' => true
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Product already in wishlist',
            'wishlist_count' => $wishlistCount,
            'in_wishlist' => true
        ]);
    }

    /**
     * Remove from wishlist (by product_id)
     */
    public function remove(Request $request, $id)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Please login'
            ], 401);
        }

        // Check if $id is a product_id or wishlist id
        $wishlist = Wishlist::where('user_id', Auth::id());

        if (is_numeric($id)) {
            // Try to find by product_id first
            $checkByProduct = $wishlist->where('product_id', $id)->first();
            if ($checkByProduct) {
                $wishlist = $checkByProduct;
            } else {
                // Try by wishlist id
                $wishlist = Wishlist::where('user_id', Auth::id())
                    ->where('id', $id)
                    ->first();
            }
        } else {
            $wishlist = $wishlist->where('id', $id)->first();
        }

        if ($wishlist) {
            $wishlist->delete();
            $wishlistCount = Wishlist::where('user_id', Auth::id())->count();
            return response()->json([
                'success' => true,
                'message' => 'Product removed from wishlist',
                'wishlist_count' => $wishlistCount,
                'in_wishlist' => false
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Item not found'
        ], 404);
    }

    /**
     * Check if product is in wishlist
     */
    public function check(Request $request)
    {
        if (!Auth::check()) {
            return response()->json([
                'in_wishlist' => false,
                'wishlist_count' => 0
            ]);
        }

        $wishlistCount = Wishlist::where('user_id', Auth::id())->count();

        // If no product_id provided, just return count
        if (!$request->filled('product_id') || $request->product_id == 0) {
            return response()->json([
                'in_wishlist' => false,
                'wishlist_count' => $wishlistCount
            ]);
        }

        $exists = Wishlist::where('user_id', Auth::id())
            ->where('product_id', $request->product_id)
            ->exists();

        $wishlistCount = Wishlist::where('user_id', Auth::id())->count();

        return response()->json([
            'in_wishlist' => $exists,
            'wishlist_count' => $wishlistCount
        ]);
    }
}
