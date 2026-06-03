<?php
// app/Http/Controllers/Branding/GalleryController.php

namespace App\Http\Controllers\Branding;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index(Request $request)
    {
        $query = Gallery::where('type', 'image')->orderBy('sort_order');
        
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }
        
        $galleries = $query->paginate(24);
        $featured = Gallery::where('is_featured', true)->where('type', 'image')->first();
        $categories = Gallery::select('category')->whereNotNull('category')->distinct()->pluck('category');
        
        return view('pages.gallery', compact('galleries', 'featured', 'categories'));
    }
    
    public function category($category)
    {
        $galleries = Gallery::where('category', $category)
            ->where('type', 'image')
            ->orderBy('sort_order')
            ->paginate(24);
            
        return view('pages.gallery-category', compact('galleries', 'category'));
    }
    
    public function show(Gallery $gallery)
    {
        $related = Gallery::where('category', $gallery->category)
            ->where('id', '!=', $gallery->id)
            ->where('type', 'image')
            ->limit(12)
            ->get();
            
        return view('pages.gallery-detail', compact('gallery', 'related'));
    }

    
}