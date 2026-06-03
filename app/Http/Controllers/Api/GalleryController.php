<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Gallery;

class GalleryController extends Controller
{
    public function index()
    {
        $galleries = Gallery::where('type', 'image')
            ->orderBy('sort_order')
            ->get();
        
        return response()->json([
            'success' => true,
            'data' => $galleries
        ]);
    }
}