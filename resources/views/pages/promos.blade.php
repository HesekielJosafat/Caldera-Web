@extends('layouts.app')

@section('title', 'Promos')

@section('content')
<div class="container py-5">
    <div class="text-center mb-5">
        <h1 class="display-4 fw-bold mb-3">Special Promos</h1>
        <p class="lead text-muted">Get exciting discounts and offers</p>
    </div>

    <div class="row g-4">
        @forelse($promos as $promo)
        <div class="col-md-6 col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <img src="{{ asset('storage/' . $promo->banner_image) }}" class="card-img-top" alt="{{ $promo->title }}" style="height: 200px; object-fit: cover;">
                <div class="card-body">
                    <span class="badge bg-danger mb-2">Promo</span>
                    <h5 class="fw-bold">{{ $promo->title }}</h5>
                    <p class="text-muted small">{{ Str::limit($promo->description, 100) }}</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-primary fw-bold">
                            @if($promo->discount_type == 'percentage')
                                Diskon {{ $promo->discount_value }}%
                            @else
                                Diskon Rp {{ number_format($promo->discount_value, 0, ',', '.') }}
                            @endif
                        </span>
                        <small class="text-muted">Code: {{ $promo->promo_code }}</small>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0 pb-3">
                    <a href="{{ route('branding.promos.detail', $promo->slug) }}" class="btn btn-outline-primary w-100">View Details</a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <i class="fas fa-tags fa-4x text-muted mb-3"></i>
            <p class="text-muted">Belum ada promo</p>
        </div>
        @endforelse
    </div>

    {{ $promos->links() }}
</div>
@endsection