@props(['image', 'quote', 'name', 'position', 'rating'])

<div class="testimonial-card position-relative p-5 fade-in-up" 
     style="background: white; border-radius: 2rem; box-shadow: 0 10px 30px -5px rgba(0,0,0,0.1); transition: all 0.3s ease;">
    
    <!-- Quote Icon -->
    <i class="fas fa-quote-right position-absolute" 
       style="font-size: 5rem; top: 20px; right: 30px; color: #667eea; opacity: 0.1; transition: all 0.3s ease;"></i>
    
    <!-- Content -->
    <div class="text-center position-relative" style="z-index: 2;">
        <!-- Avatar -->
        <div class="mb-4">
            <img src="{{ $image }}" 
                 class="rounded-circle border border-4 border-primary" 
                 width="100" height="100" 
                 alt="{{ $name }}"
                 style="object-fit: cover; box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);">
        </div>
        
        <!-- Quote -->
        <p class="text-secondary fst-italic fs-5 mb-4" style="line-height: 1.6;">"{{ $quote }}"</p>
        
        <!-- Author Info -->
        <h5 class="fw-bold mb-1" style="color: #333;">{{ $name }}</h5>
        <p class="text-sm text-primary mb-3">{{ $position }}</p>
        
        <!-- Rating -->
        <div class="rating d-flex justify-content-center gap-1">
            @for($i = 1; $i <= 5; $i++)
                @if($i <= floor($rating))
                    <i class="fas fa-star text-warning" style="font-size: 1.2rem;"></i>
                @elseif($i - $rating <= 0.5 && $rating - floor($rating) > 0)
                    <i class="fas fa-star-half-alt text-warning" style="font-size: 1.2rem;"></i>
                @else
                    <i class="far fa-star text-warning" style="font-size: 1.2rem;"></i>
                @endif
            @endfor
        </div>
    </div>
</div>

@push('styles')
<style>
/* Hover effects */
.testimonial-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 40px -10px rgba(102, 126, 234, 0.3) !important;
}

.testimonial-card:hover .fa-quote-right {
    opacity: 0.2 !important;
    transform: scale(1.1);
}

.testimonial-card:hover img {
    border-color: #764ba2 !important;
}

/* Dark mode styles */
body.dark-mode .testimonial-card {
    background: #2d2d2d !important;
    border: 1px solid #404040;
}

body.dark-mode .testimonial-card p {
    color: #ccc !important;
}

body.dark-mode .testimonial-card h5 {
    color: #fff !important;
}

body.dark-mode .testimonial-card .text-primary {
    color: #ff80ab !important;
}

body.dark-mode .testimonial-card .border-primary {
    border-color: #ff80ab !important;
}

/* Carousel controls positioning */
.carousel-control-prev,
.carousel-control-next {
    width: 50px;
    height: 50px;
    background: #667eea;
    border-radius: 50%;
    top: 50%;
    transform: translateY(-50%);
    opacity: 0.8;
    transition: all 0.3s ease;
}

.carousel-control-prev {
    left: -25px;
}

.carousel-control-next {
    right: -25px;
}

.carousel-control-prev:hover,
.carousel-control-next:hover {
    opacity: 1;
    transform: translateY(-50%) scale(1.1);
    background: #764ba2;
}

/* Responsive */
@media (max-width: 768px) {
    .testimonial-card {
        padding: 2rem !important;
    }
    
    .testimonial-card .fa-quote-right {
        font-size: 4rem !important;
        top: 15px !important;
        right: 20px !important;
    }
    
    .testimonial-card p {
        font-size: 1rem !important;
    }
    
    .carousel-control-prev {
        left: -15px;
    }
    
    .carousel-control-next {
        right: -15px;
    }
}

@media (max-width: 576px) {
    .testimonial-card {
        padding: 1.5rem !important;
    }
    
    .testimonial-card img {
        width: 80px !important;
        height: 80px !important;
    }
    
    .carousel-control-prev,
    .carousel-control-next {
        width: 40px;
        height: 40px;
    }
    
    .carousel-control-prev {
        left: -10px;
    }
    
    .carousel-control-next {
        right: -10px;
    }
}
</style>
@endpush