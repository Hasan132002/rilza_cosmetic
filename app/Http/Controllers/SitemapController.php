<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Blog;
use App\Models\Page;
use Illuminate\Http\Request;

class SitemapController extends Controller
{
    public function index()
    {
        $products = Product::active()->get();
        $categories = Category::all();
        $blogs = Blog::where('is_published', true)->get();
        $pages = Page::where('is_published', true)->get();

        return response()->view('sitemap', compact('products', 'categories', 'blogs', 'pages'))
            ->header('Content-Type', 'text/xml');
    }
}
