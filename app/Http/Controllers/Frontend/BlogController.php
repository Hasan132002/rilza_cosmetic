<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * Display a listing of blog posts.
     */
    public function index()
    {
        $blogs = Blog::with('author')
            ->published()
            ->latest()
            ->paginate(9);

        return view('frontend.blog.index', compact('blogs'));
    }

    /**
     * Display the specified blog post.
     */
    public function show($slug)
    {
        $blog = Blog::with('author')
            ->published()
            ->where('slug', $slug)
            ->firstOrFail();

        // Get related posts (latest 3 published posts excluding current)
        $relatedBlogs = Blog::published()
            ->where('id', '!=', $blog->id)
            ->latest()
            ->take(3)
            ->get();

        return view('frontend.blog.show', compact('blog', 'relatedBlogs'));
    }
}
