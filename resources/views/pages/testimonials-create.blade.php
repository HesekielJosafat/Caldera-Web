@extends('layouts.app')

@section('title', 'Write a Review')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent text-center pt-4">
                    <h4 class="fw-bold mb-2">Write Your Review</h4>
                    <p class="text-muted">Share your experience at Caldera Resto & Pool</p>
                </div>
                <div class="card-body p-4">
                    @if(session('success'))
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                        </div>
                    @endif
                    
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    <form action="{{ route('branding.testimonials.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Your Name <span class="text-danger">*</span></label>
                                <input type="text" name="customer_name" class="form-control @error('customer_name') is-invalid @enderror" value="{{ old('customer_name') }}" required>
                                @error('customer_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Email (Optional)</label>
                                <input type="email" name="customer_email" class="form-control" value="{{ old('customer_email') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Service Type</label>
                                <select name="service_type" class="form-control">
                                    <option value="">Select Service</option>
                                    <option value="restaurant" {{ old('service_type') == 'restaurant' ? 'selected' : '' }}>Restaurant</option>
                                    <option value="pool" {{ old('service_type') == 'pool' ? 'selected' : '' }}>Pool</option>
                                    <option value="event" {{ old('service_type') == 'event' ? 'selected' : '' }}>Event</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Visit Date</label>
                                <input type="date" name="visit_date" class="form-control" value="{{ old('visit_date') }}" max="{{ date('Y-m-d') }}">
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label">Your Photo (Optional)</label>
                                <input type="file" name="customer_photo" class="form-control" accept="image/*">
                                <small class="text-muted">Max 2MB. JPG, JPEG, or PNG</small>
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label">Rating <span class="text-danger">*</span></label>
                                <div class="rating-input">
                                    <i class="far fa-star fa-2x" data-value="1"></i>
                                    <i class="far fa-star fa-2x" data-value="2"></i>
                                    <i class="far fa-star fa-2x" data-value="3"></i>
                                    <i class="far fa-star fa-2x" data-value="4"></i>
                                    <i class="far fa-star fa-2x" data-value="5"></i>
                                    <input type="hidden" name="rating" id="rating" value="{{ old('rating') }}" required>
                                </div>
                                @error('rating')<div class="text-danger small">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label">Your Review <span class="text-danger">*</span></label>
                                <textarea name="comment" class="form-control @error('comment') is-invalid @enderror" rows="5" placeholder="Tell us about your experience..." required>{{ old('comment') }}</textarea>
                                <small class="text-muted">Min 10 characters</small>
                                @error('comment')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        
                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-primary btn-lg px-5">
                                <i class="fas fa-paper-plane me-2"></i>Submit Review
                            </button>
                            <a href="{{ route('branding.testimonials') }}" class="btn btn-outline-secondary btn-lg px-5 ms-2">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.rating-input i {
    cursor: pointer;
    transition: all 0.3s ease;
    margin-right: 5px;
    color: #ddd;
}

.rating-input i:hover,
.rating-input i.active {
    color: #ffc107;
}
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const stars = document.querySelectorAll('.rating-input i');
        const ratingInput = document.getElementById('rating');
        
        // Set initial rating from old value
        const oldRating = ratingInput.value;
        if (oldRating) {
            highlightStars(parseInt(oldRating), true);
        }
        
        stars.forEach(star => {
            star.addEventListener('mouseenter', function() {
                const value = parseInt(this.dataset.value);
                highlightStars(value);
            });
            
            star.addEventListener('click', function() {
                const value = parseInt(this.dataset.value);
                ratingInput.value = value;
                highlightStars(value, true);
            });
        });
        
        document.querySelector('.rating-input').addEventListener('mouseleave', function() {
            const currentValue = parseInt(ratingInput.value) || 0;
            highlightStars(currentValue, true);
        });
        
        function highlightStars(value, setActive = false) {
            stars.forEach((star, index) => {
                if (index < value) {
                    if (setActive) {
                        star.classList.add('active');
                    }
                    star.classList.remove('far');
                    star.classList.add('fas');
                } else {
                    if (setActive) {
                        star.classList.remove('active');
                    }
                    star.classList.remove('fas');
                    star.classList.add('far');
                }
            });
        }
    });
</script>
@endsection