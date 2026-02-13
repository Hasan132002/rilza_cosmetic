<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function show($slug)
    {
        $product = Product::with(['category', 'images', 'variants', 'badges'])
            ->where('slug', $slug)
            ->active()
            ->firstOrFail();

        // Increment views count
        $product->increment('views_count');

        // Get related products from same category
        $relatedProducts = Product::with(['images', 'badges'])
            ->active()
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();

        return view('frontend.product', compact('product', 'relatedProducts'));
    }

    /**
     * Get product data via API for quick view modal
     */
    public function apiShow($id)
    {
        $product = Product::with(['category', 'images', 'variants', 'badges'])
            ->active()
            ->findOrFail($id);

        return response()->json([
            'success' => true,
            'product' => [
                'id' => $product->id,
                'name' => $product->name,
                'slug' => $product->slug,
                'description' => $product->description,
                'short_description' => $product->short_description,
                'category' => [
                    'id' => $product->category->id,
                    'name' => $product->category->name,
                    'slug' => $product->category->slug
                ],
                'base_price' => (float) $product->base_price,
                'discount_price' => (float) ($product->discount_price ?? $product->base_price),
                'is_on_sale' => (bool) $product->is_on_sale,
                'discount_percentage' => (int) ($product->discount_percentage ?? 0),
                'stock_quantity' => (int) $product->stock_quantity,
                'is_low_stock' => (bool) $product->is_low_stock,
                'images' => $product->images->map(fn($image) => [
                    'id' => $image->id,
                    'image_path' => $image->image_path,
                    'alt_text' => $image->alt_text
                ])->toArray(),
                'badges' => $product->badges->map(fn($badge) => [
                    'id' => $badge->id,
                    'name' => $badge->name,
                    'icon' => $badge->icon,
                    'color_code' => $badge->color_code
                ])->toArray()
            ]
        ]);
    }
}
