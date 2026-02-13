<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['category', 'images', 'badges'])->active();

        // Filter by category (supports both ID and slug)
        if ($request->has('category')) {
            $categoryParam = $request->category;
            if (is_numeric($categoryParam)) {
                $query->where('category_id', $categoryParam);
            } else {
                // Find category by slug
                $category = Category::where('slug', $categoryParam)->first();
                if ($category) {
                    $query->where('category_id', $category->id);
                }
            }
        }

        // Filter by price range
        if ($request->has('min_price')) {
            $query->where('base_price', '>=', $request->min_price);
        }
        if ($request->has('max_price')) {
            $query->where('base_price', '<=', $request->max_price);
        }

        // Filter by skin type
        if ($request->has('skin_type')) {
            $query->where('skin_type', $request->skin_type);
        }

        // Search
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $products = $query->paginate(12);

        // Cache categories for 1 hour (only those with products)
        $categories = Cache::remember('frontend.categories', 3600, function () {
            return Category::active()->parent()->has('products')->get();
        });

        return view('frontend.shop', compact('products', 'categories'));
    }

    public function category($slug)
    {
        $category = Category::where('slug', $slug)->active()->firstOrFail();

        // Get category IDs to include (current category + children if parent)
        $categoryIds = [$category->id];
        if ($category->children()->exists()) {
            $categoryIds = array_merge($categoryIds, $category->children()->pluck('id')->toArray());
        }

        $products = Product::with(['images', 'badges'])
            ->active()
            ->whereIn('category_id', $categoryIds)
            ->paginate(12);

        return view('frontend.category', compact('category', 'products'));
    }
}
