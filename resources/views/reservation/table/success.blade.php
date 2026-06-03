@extends('layouts.app')

@section('title', 'Reservasi Berhasil')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-lg text-center">
                <div class="card-body p-5">
                    <!-- Icon Success -->
                    <div class="mb-4">
                        <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex p-3">
                            <i class="fas fa-check-circle fa-4x text-success"></i>
                        </div>
                    </div>
                    
                    <h2 class="fw-bold mb-3">Reservasi Berhasil!</h2>
                    <p class="text-muted mb-4">Terima kasih telah melakukan reservasi di Caldera Resto & Pool.</p>
                    
                    <!-- Booking Code -->
                    <div class="bg-light rounded-3 p-4 mb-4">
                        <small class="text-muted">Kode Booking Anda</small>
                        <h3 class="fw-bold text-primary mb-0">{{ $reservation->booking_code }}</h3>
                    </div>
                    
                    <!-- Detail Reservasi -->
                    <div class="text-start mb-4">
                        <h5 class="fw-bold mb-3">Detail Reservasi:</h5>
                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <span class="text-muted">Nama:</span>
                                <p class="fw-bold mb-0">{{ $reservation->customer_name }}</p>
                            </div>
                            <div class="col-md-6 mb-2">
                                <span class="text-muted">Tanggal:</span>
                                <p class="fw-bold mb-0">{{ \Carbon\Carbon::parse($reservation->reservation_date)->format('d F Y') }}</p>
                            </div>
                            <div class="col-md-6 mb-2">
                                <span class="text-muted">Jam:</span>
                                <p class="fw-bold mb-0">{{ $reservation->reservation_time }}</p>
                            </div>
                            <div class="col-md-6 mb-2">
                                <span class="text-muted">Jumlah Tamu:</span>
                                <p class="fw-bold mb-0">{{ $reservation->number_of_guests }} orang</p>
                            </div>
                            <div class="col-md-12 mb-2">
                                <span class="text-muted">DP yang harus dibayar:</span>
                                <p class="fw-bold text-primary mb-0">Rp {{ number_format($reservation->down_payment, 0, ',', '.') }}</p>
                            </div>
                            @if($reservation->special_requests)
                            <div class="col-md-12">
                                <span class="text-muted">Permintaan Khusus:</span>
                                <p class="mb-0">{{ $reservation->special_requests }}</p>
                            </div>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Informasi Pembayaran -->
                    <div class="alert alert-warning text-start">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Informasi Pembayaran:</strong>
                        <p class="mb-0 mt-1 small">Silakan lakukan pembayaran DP sebesar <strong>Rp {{ number_format($reservation->down_payment, 0, ',', '.') }}</strong> ke rekening berikut:</p>
                        <hr class="my-2">
                        <p class="mb-0 small">
                            Bank BCA: 1234567890 a.n. Caldera Resto<br>
                            Bank Mandiri: 0987654321 a.n. Caldera Resto
                        </p>
                    </div>
                    
                    <!-- Tombol Aksi -->
                    <div class="d-flex gap-3 justify-content-center">
                        <a href="{{ route('reservation.table.view', $reservation->booking_code) }}" class="btn btn-outline-primary">
                            <i class="fas fa-eye me-2"></i> Lihat Detail
                        </a>
                        <a href="{{ route('branding.home') }}" class="btn btn-primary">
                            <i class="fas fa-home me-2"></i> Kembali ke Beranda
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection