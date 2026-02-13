<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductBadge;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Product::with(['category', 'images', 'badges']);

        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('sku', 'LIKE', "%{$search}%");
            });
        }

        // Filter by low stock
        if ($request->has('low_stock')) {
            $query->whereColumn('stock_quantity', '<=', 'low_stock_threshold')
                  ->where('stock_quantity', '>', 0)
                  ->orderBy('stock_quantity', 'asc');
        } else {
            $query->latest();
        }

        $products = $query->paginate(20);

        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::active()->get();
        $badges = ProductBadge::active()->get();

        return view('admin.products.create', compact('categories', 'badges'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'sku' => 'required|string|unique:products,sku',
            'short_description' => 'nullable|string',
            'long_description' => 'nullable|string',
            'ingredients' => 'nullable|string',
            'how_to_use' => 'nullable|string',
            'skin_type' => 'required|in:all,dry,oily,combination,sensitive',
            'base_price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
            'discount_percentage' => 'nullable|integer|min:0|max:100',
            'stock_quantity' => 'required|integer|min:0',
            'low_stock_threshold' => 'integer|min:0',
            'is_featured' => 'boolean',
            'is_bestseller' => 'boolean',
            'is_new_arrival' => 'boolean',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'is_active' => 'boolean',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'badge_ids' => 'nullable|array',
            'badge_ids.*' => 'exists:product_badges,id',
        ]);

        // Create product
        $product = Product::create($validated);

        // Handle multiple image uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('products', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $path,
                    'is_primary' => $index === 0, // First image is primary
                    'sort_order' => $index,
                ]);
            }
        }

        // Attach badges
        if ($request->has('badge_ids')) {
            $product->badges()->attach($request->badge_ids);
        }

        // Save B2B pricing if provided
        if ($request->has('b2b_wholesale_price')) {
            $product->b2bPricing()->create([
                'wholesale_price' => $request->b2b_wholesale_price,
                'minimum_order_quantity' => $request->b2b_moq ?? 10,
                'bulk_tier_1_qty' => $request->bulk_tier_1_qty,
                'bulk_tier_1_price' => $request->bulk_tier_1_price,
                'bulk_tier_2_qty' => $request->bulk_tier_2_qty,
                'bulk_tier_2_price' => $request->bulk_tier_2_price,
                'bulk_tier_3_qty' => $request->bulk_tier_3_qty,
                'bulk_tier_3_price' => $request->bulk_tier_3_price,
                'is_available_for_b2b' => $request->boolean('is_available_for_b2b', true),
            ]);
        }

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $product->load(['category', 'images', 'variants', 'badges']);
        return view('admin.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::active()->get();
        $badges = ProductBadge::active()->get();
        $product->load(['images', 'badges']);

        return view('admin.products.edit', compact('product', 'categories', 'badges'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'sku' => 'required|string|unique:products,sku,' . $product->id,
            'short_description' => 'nullable|string',
            'long_description' => 'nullable|string',
            'ingredients' => 'nullable|string',
            'how_to_use' => 'nullable|string',
            'skin_type' => 'required|in:all,dry,oily,combination,sensitive',
            'base_price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
            'discount_percentage' => 'nullable|integer|min:0|max:100',
            'stock_quantity' => 'required|integer|min:0',
            'low_stock_threshold' => 'integer|min:0',
            'is_featured' => 'boolean',
            'is_bestseller' => 'boolean',
            'is_new_arrival' => 'boolean',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'is_active' => 'boolean',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'badge_ids' => 'nullable|array',
            'badge_ids.*' => 'exists:product_badges,id',
        ]);

        // Update product
        $product->update($validated);

        // Handle new image uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('products', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $path,
                    'is_primary' => $product->images()->count() === 0 && $index === 0,
                    'sort_order' => $product->images()->max('sort_order') + $index + 1,
                ]);
            }
        }

        // Sync badges
        if ($request->has('badge_ids')) {
            $product->badges()->sync($request->badge_ids);
        } else {
            $product->badges()->detach();
        }

        // Update or create B2B pricing
        if ($request->has('b2b_wholesale_price')) {
            $product->b2bPricing()->updateOrCreate(
                ['product_id' => $product->id],
                [
                    'wholesale_price' => $request->b2b_wholesale_price,
                    'minimum_order_quantity' => $request->b2b_moq ?? 10,
                    'bulk_tier_1_qty' => $request->bulk_tier_1_qty,
                    'bulk_tier_1_price' => $request->bulk_tier_1_price,
                    'bulk_tier_2_qty' => $request->bulk_tier_2_qty,
                    'bulk_tier_2_price' => $request->bulk_tier_2_price,
                    'bulk_tier_3_qty' => $request->bulk_tier_3_qty,
                    'bulk_tier_3_price' => $request->bulk_tier_3_price,
                    'is_available_for_b2b' => $request->boolean('is_available_for_b2b', true),
                ]
            );
        }

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        // Delete all product images from storage
        foreach ($product->images as $image) {
            Storage::disk('public')->delete($image->image_path);
        }

        // Delete product (cascade will handle images and pivot tables)
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully!');
    }
}
