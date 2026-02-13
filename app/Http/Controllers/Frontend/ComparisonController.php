<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\ProductComparison;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ComparisonController extends Controller
{
    public function __construct()
    {
    }

    /**
     * Display comparison page
     */
    public function index()
    {
        $comparisons = ProductComparison::with('product.images', 'product.category')
            ->where('user_id', Auth::id())
            ->latest()
            ->limit(4) // Maximum 4 products to compare
            ->get();

        return view('frontend.compare', compact('comparisons'));
    }

    /**
     * Add to comparison
     */
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id'
        ]);

        // Check if user already has 4 products in comparison
        $count = ProductComparison::where('user_id', Auth::id())->count();
        if ($count >= 4) {
            return response()->json([
                'success' => false,
                'message' => 'You can only compare up to 4 products at a time'
            ]);
        }

        $comparison = ProductComparison::firstOrCreate([
            'user_id' => Auth::id(),
            'product_id' => $request->product_id
        ]);

        if ($comparison->wasRecentlyCreated) {
            return response()->json([
                'success' => true,
                'message' => 'Product added to comparison!'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Product already in comparison'
        ]);
    }

    /**
     * Remove from comparison
     */
    public function remove($id)
    {
        $comparison = ProductComparison::where('user_id', Auth::id())
            ->where('id', $id)
            ->first();

        if ($comparison) {
            $comparison->delete();
            return response()->json([
                'success' => true,
                'message' => 'Product removed from comparison'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Item not found'
        ], 404);
    }

    /**
     * Clear all comparisons
     */
    public function clear()
    {
        ProductComparison::where('user_id', Auth::id())->delete();

        return response()->json([
            'success' => true,
            'message' => 'Comparison cleared'
        ]);
    }
}
