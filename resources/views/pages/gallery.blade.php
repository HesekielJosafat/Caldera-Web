@extends('layouts.app')

@section('title', 'Gallery')

@section('content')
<div class="container py-5">
    <div class="text-center mb-5">
        <h1 class="display-4 fw-bold mb-2">Our Gallery</h1>
        <div class="section-divider"></div>
        <p class="lead text-muted">Moments captured at Caldera Resto & Pool</p>
    </div>

    <!-- Featured Image -->
    @if($featured)
    <div class="row mb-5">
        <div class="col-12">
            <div class="position-relative overflow-hidden rounded-4 shadow-lg">
                <img src="{{ asset('storage/' . $featured->file_path) }}"
                     class="w-100"
                     alt="{{ $featured->title }}"
                     style="height: 400px; object-fit: cover;">
                <div class="position-absolute bottom-0 start-0 end-0 p-4" style="background: linear-gradient(to top, rgba(28,52,81,0.9), transparent);">
                    <h4 class="mb-0 text-white" style="font-family: 'Playfair Display', serif;">{{ $featured->title }}</h4>
                    <p class="mb-0 small" style="color: #c1a067;">{{ $featured->description }}</p>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Filter Categories -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-center gap-2 flex-wrap">
                <a href="{{ route('branding.gallery') }}"
                   class="btn btn-filter {{ !request('category') ? 'active' : '' }}">
                    All
                </a>
                @foreach($categories as $cat)
                <a href="{{ route('branding.gallery.category', $cat) }}"
                   class="btn btn-filter {{ request('category') == $cat ? 'active' : '' }}">
                    {{ ucfirst($cat) }}
                </a>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Gallery Grid -->
    <div class="row g-4">
        @forelse($galleries as $gallery)
        <div class="col-md-6 col-lg-4 col-xl-3">
            <div class="card border-0 shadow-sm h-100 gallery-card">
                <div class="position-relative overflow-hidden" style="height: 250px;">
                    <img src="{{ asset('storage/' . $gallery->file_path) }}"
                         class="card-img-top gallery-img"
                         alt="{{ $gallery->title }}"
                         style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s ease;">
                    <div class="gallery-overlay position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center">
                        <a href="{{ route('branding.gallery.show', $gallery) }}" class="btn btn-light rounded-circle mx-1 overlay-btn">
                            <i class="fas fa-search"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body text-center p-3">
                    <h6 class="fw-bold mb-1" style="color: #1c3451;">{{ $gallery->title }}</h6>
                    <small class="gallery-category-badge">{{ ucfirst($gallery->category) }}</small>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <i class="fas fa-images fa-4x mb-3" style="color: #c1a067; opacity: 0.5;"></i>
            <p class="text-muted">Belum ada foto gallery</p>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-5">
        {{ $galleries->links() }}
    </div>
</div>
@endsection

@push('styles')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&display=swap');

    h1.display-4 {
        font-family: 'Playfair Display', serif;
        color: #1c3451;
    }

    .section-divider {
        width: 50px;
        height: 3px;
        background: #c1a067;
        margin: 12px auto 16px;
        border-radius: 2px;
    }

    /* Filter buttons */
    .btn-filter {
        background: white;
        color: #4a5568;
        border: 1.5px solid #d1d5db;
        border-radius: 20px;
        padding: 6px 18px;
        font-size: 13px;
        font-weight: 500;
        transition: all 0.2s;
    }

    .btn-filter:hover {
        border-color: #1c3451;
        color: #1c3451;
    }

    .btn-filter.active {
        background: #1c3451;
        color: white;
        border-color: #1c3451;
    }

    /* Gallery card */
    .gallery-card {
        cursor: pointer;
        overflow: hidden;
        border-radius: 14px !important;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border-top: 3px solid transparent !important;
    }

    .gallery-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 28px rgba(28,52,81,0.12) !important;
        border-top: 3px solid #c1a067 !important;
    }

    .gallery-card:hover .gallery-img {
        transform: scale(1.06);
    }

    /* Overlay */
    .gallery-overlay {
        background: rgba(28, 52, 81, 0.55);
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .gallery-card:hover .gallery-overlay {
        opacity: 1;
    }

    .overlay-btn {
        width: 42px;
        height: 42px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: white;
        color: #1c3451;
        border: none;
        transition: background 0.2s;
    }

    .overlay-btn:hover {
        background: #c1a067;
        color: white;
    }

    /* Category badge */
    .gallery-category-badge {
        background: #f0ebe0;
        color: #c1a067;
        font-weight: 600;
        font-size: 11px;
        padding: 3px 10px;
        border-radius: 20px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
</style>
@endpush