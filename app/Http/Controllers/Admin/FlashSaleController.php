<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FlashSale;
use App\Models\Product;
use Illuminate\Http\Request;

class FlashSaleController extends Controller
{
    /**
     * Display a listing of flash sales.
     */
    public function index()
    {
        $flashSales = FlashSale::with('products')
            ->orderBy('starts_at', 'desc')
            ->paginate(15);

        return view('admin.flash-sales.index', compact('flashSales'));
    }

    /**
     * Show the form for creating a new flash sale.
     */
    public function create()
    {
        $products = Product::active()->orderBy('name')->get();
        return view('admin.flash-sales.create', compact('products'));
    }

    /**
     * Store a newly created flash sale in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'discount_percentage' => 'required|integer|min:1|max:99',
            'starts_at' => 'required|date|after_or_equal:now',
            'ends_at' => 'required|date|after:starts_at',
            'is_active' => 'boolean',
            'products' => 'required|array|min:1',
            'products.*' => 'exists:products,id',
        ]);

        $flashSale = FlashSale::create([
            'title' => $validated['title'],
            'discount_percentage' => $validated['discount_percentage'],
            'starts_at' => $validated['starts_at'],
            'ends_at' => $validated['ends_at'],
            'is_active' => $request->has('is_active'),
        ]);

        $flashSale->products()->attach($validated['products']);

        return redirect()
            ->route('admin.flash-sales.index')
            ->with('success', 'Flash sale created successfully!');
    }

    /**
     * Show the form for editing the specified flash sale.
     */
    public function edit(FlashSale $flashSale)
    {
        $flashSale->load('products');
        $products = Product::active()->orderBy('name')->get();

        return view('admin.flash-sales.edit', compact('flashSale', 'products'));
    }

    /**
     * Update the specified flash sale in storage.
     */
    public function update(Request $request, FlashSale $flashSale)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'discount_percentage' => 'required|integer|min:1|max:99',
            'starts_at' => 'required|date',
            'ends_at' => 'required|date|after:starts_at',
            'is_active' => 'boolean',
            'products' => 'required|array|min:1',
            'products.*' => 'exists:products,id',
        ]);

        $flashSale->update([
            'title' => $validated['title'],
            'discount_percentage' => $validated['discount_percentage'],
            'starts_at' => $validated['starts_at'],
            'ends_at' => $validated['ends_at'],
            'is_active' => $request->has('is_active'),
        ]);

        $flashSale->products()->sync($validated['products']);

        return redirect()
            ->route('admin.flash-sales.index')
            ->with('success', 'Flash sale updated successfully!');
    }

    /**
     * Remove the specified flash sale from storage.
     */
    public function destroy(FlashSale $flashSale)
    {
        $flashSale->delete();

        return redirect()
            ->route('admin.flash-sales.index')
            ->with('success', 'Flash sale deleted successfully!');
    }
}
