@extends('layouts.app')

@section('title', $gallery->title)

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Back Button -->
            <div class="mb-4">
                <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i> Back to Gallery
                </a>
            </div>
            
            <!-- Main Image -->
            <div class="card border-0 shadow-sm overflow-hidden mb-4">
                <img src="{{ asset('storage/' . $gallery->file_path) }}" 
                     class="w-100" 
                     alt="{{ $gallery->title }}"
                     style="max-height: 500px; object-fit: contain; background: #f5f5f5;">
            </div>
            
            <!-- Image Info -->
            <div class="card border-0 shadow-sm p-4 mb-4">
                <h2 class="fw-bold mb-3">{{ $gallery->title }}</h2>
                <div class="mb-3">
                    <span class="badge bg-primary">{{ ucfirst($gallery->category) }}</span>
                    @if($gallery->is_featured)
                        <span class="badge bg-warning">Featured</span>
                    @endif
                </div>
                @if($gallery->description)
                    <p class="text-muted">{{ $gallery->description }}</p>
                @endif
                <hr>
                <div class="d-flex justify-content-between align-items-center">
                    <small class="text-muted">
                        <i class="fas fa-calendar-alt me-1"></i> 
                        {{ $gallery->created_at->format('d F Y') }}
                    </small>
                    <div class="d-flex gap-2">
                        <button class="btn btn-sm btn-outline-primary" onclick="shareImage()">
                            <i class="fas fa-share-alt me-1"></i> Share
                        </button>
                        <button class="btn btn-sm btn-outline-danger" onclick="downloadImage()">
                            <i class="fas fa-download me-1"></i> Download
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Related Images -->
            @if($related->count() > 0)
            <div class="mt-4">
                <h4 class="fw-bold mb-4">Related Photos</h4>
                <div class="row g-3">
                    @foreach($related as $item)
                    <div class="col-6 col-md-3">
                        <a href="{{ route('branding.gallery.show', $item) }}">
                            <img src="{{ asset('storage/' . $item->file_path) }}" 
                                 class="img-fluid rounded-3 shadow-sm" 
                                 alt="{{ $item->title }}"
                                 style="height: 120px; width: 100%; object-fit: cover;">
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<script>
    function shareImage() {
        if (navigator.share) {
            navigator.share({
                title: '{{ $gallery->title }}',
                text: 'Check out this photo from Caldera Resto & Pool!',
                url: window.location.href
            }).catch(console.error);
        } else {
            navigator.clipboard.writeText(window.location.href);
            alert('Link copied to clipboard!');
        }
    }
    
    function downloadImage() {
        const link = document.createElement('a');
        link.href = '{{ asset('storage/' . $gallery->file_path) }}';
        link.download = '{{ $gallery->title }}.jpg';
        link.click();
    }
</script>
@endsection