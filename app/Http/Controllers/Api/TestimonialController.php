<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::where('is_approved', true)
            ->latest()
            ->get();
        
        return response()->json([
            'success' => true,
            'data' => $testimonials
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:10',
            'service_type' => 'nullable|string',
        ]);

        $testimonial = Testimonial::create([
            'customer_name' => $validated['customer_name'],
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
            'service_type' => $validated['service_type'] ?? null,
            'is_approved' => false,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Testimoni berhasil ditambahkan',
            'data' => $testimonial
        ], 201);
    }
}