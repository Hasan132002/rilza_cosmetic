<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\FlashSale;
use App\Models\Product;
use Illuminate\Http\Request;

class OffersController extends Controller
{
    public function index()
    {
        // Get active coupons
        $coupons = Coupon::where('is_active', true)
            ->where(function ($query) {
                $query->whereNull('valid_from')
                    ->orWhere('valid_from', '<=', now());
            })
            ->where(function ($query) {
                $query->whereNull('valid_until')
                    ->orWhere('valid_until', '>=', now());
            })
            ->orderBy('value', 'desc')
            ->get();

        // Get active flash sales
        $flashSales = FlashSale::with('products.images')
            ->where('is_active', true)
            ->where('starts_at', '<=', now())
            ->where('ends_at', '>=', now())
            ->get();

        // Get discounted products
        $discountedProducts = Product::with(['images', 'badges', 'category'])
            ->active()
            ->whereNotNull('discount_price')
            ->orderByRaw('((base_price - discount_price) / base_price) DESC')
            ->take(12)
            ->get();

        // Get bestsellers on sale
        $bestsellersOnSale = Product::with(['images', 'badges'])
            ->active()
            ->bestseller()
            ->whereNotNull('discount_price')
            ->take(6)
            ->get();

        return view('frontend.offers', compact('coupons', 'flashSales', 'discountedProducts', 'bestsellersOnSale'));
    }
}
