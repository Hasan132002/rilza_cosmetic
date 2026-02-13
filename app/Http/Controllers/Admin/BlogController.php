<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $blogs = Blog::with('author')
            ->latest('created_at')
            ->paginate(15);

        return view('admin.blogs.index', compact('blogs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.blogs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:blogs,slug',
            'excerpt' => 'nullable|string',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
            'is_published' => 'nullable|boolean',
            'published_at' => 'nullable|date',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
        ]);

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            $image = $request->file('featured_image');
            $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();

            // Create image manager with GD driver
            $manager = new ImageManager(new Driver());
            $processedImage = $manager->read($image);

            // Resize and optimize
            $processedImage->scale(width: 1200);

            // Save to storage
            $path = 'blogs/' . $filename;
            Storage::disk('public')->put($path, $processedImage->encode());

            $validated['featured_image'] = $path;
        }

        // Set author as current user
        $validated['author_id'] = auth()->id();

        // Handle published status
        $validated['is_published'] = $request->has('is_published') ? true : false;

        // Set published_at if published
        if ($validated['is_published'] && !$request->filled('published_at')) {
            $validated['published_at'] = now();
        }

        Blog::create($validated);

        return redirect()->route('admin.blogs.index')
            ->with('success', 'Blog post created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Blog $blog)
    {
        return redirect()->route('admin.blogs.edit', $blog);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Blog $blog)
    {
        return view('admin.blogs.edit', compact('blog'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Blog $blog)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:blogs,slug,' . $blog->id,
            'excerpt' => 'nullable|string',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
            'is_published' => 'nullable|boolean',
            'published_at' => 'nullable|date',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
        ]);

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            // Delete old image if exists
            if ($blog->featured_image) {
                Storage::disk('public')->delete($blog->featured_image);
            }

            $image = $request->file('featured_image');
            $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();

            // Create image manager with GD driver
            $manager = new ImageManager(new Driver());
            $processedImage = $manager->read($image);

            // Resize and optimize
            $processedImage->scale(width: 1200);

            // Save to storage
            $path = 'blogs/' . $filename;
            Storage::disk('public')->put($path, $processedImage->encode());

            $validated['featured_image'] = $path;
        }

        // Handle published status
        $validated['is_published'] = $request->has('is_published') ? true : false;

        // Set published_at if published and not already set
        if ($validated['is_published'] && !$request->filled('published_at') && !$blog->published_at) {
            $validated['published_at'] = now();
        }

        $blog->update($validated);

        return redirect()->route('admin.blogs.index')
            ->with('success', 'Blog post updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog)
    {
        // Delete featured image if exists
        if ($blog->featured_image) {
            Storage::disk('public')->delete($blog->featured_image);
        }

        $blog->delete();

        return redirect()->route('admin.blogs.index')
            ->with('success', 'Blog post deleted successfully!');
    }
}
