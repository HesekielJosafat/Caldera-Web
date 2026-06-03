@extends('layouts.app')

@section('title', 'Testimonial from ' . $testimonial->customer_name)

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        @if($testimonial->customer_photo)
                            <img src="{{ asset('storage/' . $testimonial->customer_photo) }}" 
                                 class="rounded-circle mb-3" 
                                 width="100" height="100" 
                                 alt="{{ $testimonial->customer_name }}">
                        @else
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($testimonial->customer_name) }}&background=667eea&color=fff&size=100" 
                                 class="rounded-circle mb-3" 
                                 width="100" height="100" 
                                 alt="{{ $testimonial->customer_name }}">
                        @endif
                        <h3 class="fw-bold mb-1">{{ $testimonial->customer_name }}</h3>
                        <p class="text-muted">
                            @if($testimonial->service_type)
                                {{ ucfirst($testimonial->service_type) }} Visitor
                            @else
                                Customer
                            @endif
                        </p>
                        <div class="mb-2">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $testimonial->rating)
                                    <i class="fas fa-star text-warning fa-lg"></i>
                                @else
                                    <i class="far fa-star text-warning fa-lg"></i>
                                @endif
                            @endfor
                        </div>
                    </div>
                    
                    <div class="text-center mb-4">
                        <i class="fas fa-quote-left fa-2x text-primary opacity-50 mb-3"></i>
                        <p class="lead fst-italic">"{{ $testimonial->comment }}"</p>
                        <i class="fas fa-quote-right fa-2x text-primary opacity-50"></i>
                    </div>
                    
                    @if($testimonial->visit_date)
                        <div class="text-center text-muted">
                            <small>
                                <i class="fas fa-calendar-alt me-1"></i> 
                                Visited on {{ \Carbon\Carbon::parse($testimonial->visit_date)->format('d F Y') }}
                            </small>
                        </div>
                    @endif
                    
                    <div class="text-center mt-4">
                        <a href="{{ route('branding.testimonials') }}" class="btn btn-outline-primary">
                            <i class="fas fa-arrow-left me-2"></i> Back to Testimonials
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection