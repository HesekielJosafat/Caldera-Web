@extends('layouts.app')

@section('title', $promo->title)

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm overflow-hidden">
                <img src="{{ asset('storage/' . $promo->banner_image) }}" class="card-img-top" alt="{{ $promo->title }}">
                <div class="card-body p-4">
                    <span class="badge bg-danger mb-3">Promo</span>
                    <h1 class="display-5 fw-bold mb-3">{{ $promo->title }}</h1>
                    <div class="mb-3">
                        <span class="text-primary fw-bold fs-4">
                            @if($promo->discount_type == 'percentage')
                                Diskon {{ $promo->discount_value }}%
                            @else
                                Diskon Rp {{ number_format($promo->discount_value, 0, ',', '.') }}
                            @endif
                        </span>
                    </div>
                    <p class="text-muted">{{ $promo->description }}</p>
                    <div class="alert alert-info">
                        <strong>Promo Code:</strong> {{ $promo->promo_code }}
                    </div>
                    <div class="alert alert-warning">
                        <strong>Valid until:</strong> {{ \Carbon\Carbon::parse($promo->end_date)->format('d F Y') }}
                    </div>
                    <a href="{{ route('branding.menu') }}" class="btn btn-primary">Order Now</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection