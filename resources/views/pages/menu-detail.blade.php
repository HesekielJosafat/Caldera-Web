@extends('layouts.app')

@section('title', $menu->name)

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-6 mb-4">
            @if($menu->image)
                <img src="{{ asset('storage/' . $menu->image) }}" class="img-fluid rounded-4 shadow-lg" alt="{{ $menu->name }}">
            @else
                <div class="bg-secondary d-flex align-items-center justify-content-center rounded-4 shadow-lg" style="height: 400px;">
                    <i class="fas fa-utensils fa-5x text-white"></i>
                </div>
            @endif
        </div>
        <div class="col-lg-6">
            <div class="mb-3">
                <span class="badge bg-primary">{{ ucfirst($menu->category) }}</span>
                @if($menu->is_recommended)
                    <span class="badge bg-success">Recommended</span>
                @endif
                @if($menu->is_available)
                    <span class="badge bg-info">Tersedia</span>
                @else
                    <span class="badge bg-secondary">Habis</span>
                @endif
            </div>
            <h1 class="display-5 fw-bold mb-3">{{ $menu->name }}</h1>
            <p class="text-secondary mb-4">{{ $menu->description }}</p>
            <h2 class="text-primary fw-bold mb-4">Rp {{ number_format($menu->price, 0, ',', '.') }}</h2>
            
            <div class="d-flex gap-3">
                <div class="input-group" style="width: 150px;">
                    <button class="btn btn-outline-secondary" type="button" onclick="decrement()">-</button>
                    <input type="number" id="quantity" class="form-control text-center" value="1" min="1" max="99">
                    <button class="btn btn-outline-secondary" type="button" onclick="increment()">+</button>
                </div>
                <button class="btn btn-primary btn-lg px-4" onclick="addToCart()">
                    <i class="fas fa-shopping-cart me-2"></i>Pesan Sekarang
                </button>
            </div>
            
            <hr class="my-4">
            
            <div class="row">
                <div class="col-6">
                    <div class="d-flex align-items-center gap-2">
                        <i class="fas fa-clock text-primary fa-2x"></i>
                        <div>
                            <small class="text-muted">Waktu Penyajian</small>
                            <p class="mb-0 fw-bold">15-20 Menit</p>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="d-flex align-items-center gap-2">
                        <i class="fas fa-tag text-primary fa-2x"></i>
                        <div>
                            <small class="text-muted">Kategori</small>
                            <p class="mb-0 fw-bold">{{ ucfirst($menu->category) }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function increment() {
        let qty = document.getElementById('quantity');
        qty.value = parseInt(qty.value) + 1;
    }
    function decrement() {
        let qty = document.getElementById('quantity');
        if (parseInt(qty.value) > 1) qty.value = parseInt(qty.value) - 1;
    }
    function addToCart() {
        let qty = document.getElementById('quantity').value;
        alert('{{ $menu->name }} (' + qty + 'x) ditambahkan ke keranjang!');
    }
</script>
@endsection