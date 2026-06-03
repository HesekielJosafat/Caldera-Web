<?php

namespace App\Http\Controllers\Branding;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TestimonialController extends Controller
{
    public function index(Request $request)
    {
        $query = Testimonial::where('is_approved', true); // ← fix

        if ($request->filled('rating')) {
            $query->where('rating', '>=', $request->rating);
        }

        if ($request->filled('service')) {
            $query->where('service_type', $request->service);
        }

        $testimonials = $query->latest()->paginate(9);

        // Rating stats
        $allApproved = Testimonial::where('is_approved', true);
        $ratingStats = [
            'total'   => $allApproved->count(),
            'average' => $allApproved->avg('rating') ?? 0,
            '5_star'  => Testimonial::where('is_approved', true)->where('rating', 5)->count(),
            '4_star'  => Testimonial::where('is_approved', true)->where('rating', 4)->count(),
            '3_star'  => Testimonial::where('is_approved', true)->where('rating', 3)->count(),
            '2_star'  => Testimonial::where('is_approved', true)->where('rating', 2)->count(),
            '1_star'  => Testimonial::where('is_approved', true)->where('rating', 1)->count(),
        ];

        return view('pages.testimonials', compact('testimonials', 'ratingStats'));
    }

    public function create()
    {
        return view('branding.testimonials-create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name'  => 'required|string|max:255',
            'customer_email' => 'nullable|email|max:255', // ← optional
            'rating'         => 'required|integer|min:1|max:5',
            'service_type'   => 'nullable|in:restaurant,pool,event',
            'comment'        => 'required|string|min:10|max:1000',
            'visit_date'     => 'nullable|date|before_or_equal:today',
        ], [
            'customer_name.required' => 'Nama harus diisi.',
            'rating.required'        => 'Rating harus dipilih.',
            'comment.required'       => 'Ulasan harus diisi.',
            'comment.min'            => 'Ulasan minimal 10 karakter.',
        ]);

        Testimonial::create([
            'customer_name'  => $validated['customer_name'],
            'customer_email' => $validated['customer_email'] ?? null,
            'rating'         => $validated['rating'],
            'service_type'   => $validated['service_type'] ?? null,
            'comment'        => $validated['comment'],
            'visit_date'     => $validated['visit_date'] ?? null,
            'is_approved' => false,
            'ip_address'     => $request->ip(),
            'user_id'        => Auth::id() ?? null,
        ]);

        return redirect()->route('branding.testimonials')
            ->with('success', 'Terima kasih! Ulasan Anda sedang dalam proses review.');
    }

    public function show(Testimonial $testimonial)
    {
        abort_if($testimonial->status !== 'approved', 404);
        return view('branding.testimonial-show', compact('testimonial'));
    }
}