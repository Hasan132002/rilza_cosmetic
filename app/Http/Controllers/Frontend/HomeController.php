<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Banner;
use App\Models\Announcement;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $banners = Banner::active()->ordered()->get();

        $announcement = Announcement::active()->latest()->first();

        $featuredProducts = Product::with(['images', 'badges'])
            ->active()
            ->featured()
            ->take(8)
            ->get();

        $newArrivals = Product::with(['images', 'badges'])
            ->active()
            ->newArrivals()
            ->take(8)
            ->get();

        $bestsellers = Product::with(['images', 'badges'])
            ->active()
            ->bestseller()
            ->take(8)
            ->get();

        $categories = Category::active()
            ->parent()
            ->whereHas('children', function($query) {
                $query->whereHas('products');
            })
            ->take(4)
            ->get();

        return view('frontend.home', compact('banners', 'announcement', 'featuredProducts', 'newArrivals', 'bestsellers', 'categories'));
    }
}
