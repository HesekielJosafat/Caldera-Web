@extends('layouts.app')

@section('title', ucfirst($category) . ' - Menu Caldera')

@section('content')
<div class="container py-5">
    <div class="text-center mb-5">
        <h1 class="display-4 fw-bold mb-3">Menu {{ ucfirst($category) }}</h1>
        <p class="lead text-secondary">Discover our delicious {{ $category }} selection</p>
    </div>
    
    <!-- Category Filter -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-center gap-2 flex-wrap">
                <a href="{{ route('branding.menu') }}" class="btn btn-outline-primary">All</a>
                <a href="{{ route('branding.menu.category', 'makanan') }}" class="btn {{ $category == 'makanan' ? 'btn-primary' : 'btn-outline-primary' }}">Makanan</a>
                <a href="{{ route('branding.menu.category', 'minuman') }}" class="btn {{ $category == 'minuman' ? 'btn-primary' : 'btn-outline-primary' }}">Minuman</a>
                <a href="{{ route('branding.menu.category', 'dessert') }}" class="btn {{ $category == 'dessert' ? 'btn-primary' : 'btn-outline-primary' }}">Dessert</a>
            </div>
        </div>
    </div>
    
    <!-- Menu Grid -->
    <div class="row g-4">
        @forelse($menus as $menu)
        <div class="col-md-6 col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                @if($menu->image)
                    <img src="{{ asset('storage/' . $menu->image) }}" class="card-img-top" alt="{{ $menu->name }}" style="height: 200px; object-fit: cover;">
                @else
                    <div class="bg-secondary d-flex align-items-center justify-content-center" style="height: 200px;">
                        <i class="fas fa-utensils fa-4x text-white"></i>
                    </div>
                @endif
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h5 class="fw-bold mb-0">{{ $menu->name }}</h5>
                        <span class="text-primary fw-bold">Rp {{ number_format($menu->price, 0, ',', '.') }}</span>
                    </div>
                    <p class="text-muted small">{{ Str::limit($menu->description, 100) }}</p>
                </div>
                
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <i class="fas fa-utensils fa-4x text-muted mb-3"></i>
            <p class="text-muted">Menu {{ $category }} sedang kosong</p>
        </div>
        @endforelse
    </div>
    
    <!-- Pagination -->
    <div class="mt-5">
        {{ $menus->links() }}
    </div>
</div>
@endsection