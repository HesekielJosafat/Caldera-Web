@extends('layouts.app')

@section('title', 'Detail Reservasi')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-lg">
                <div class="card-header bg-transparent text-center pt-4">
                    <h4 class="fw-bold mb-2">Detail Reservasi</h4>
                    <p class="text-muted">Kode Booking: <strong>{{ $reservation->booking_code }}</strong></p>
                </div>
                <div class="card-body p-4">
                    <!-- Status -->
                    <div class="text-center mb-4">
                        @if($reservation->status == 'pending')
                            <span class="badge bg-warning px-3 py-2">Menunggu Konfirmasi</span>
                        @elseif($reservation->status == 'confirmed')
                            <span class="badge bg-success px-3 py-2">Dikonfirmasi</span>
                        @elseif($reservation->status == 'cancelled')
                            <span class="badge bg-danger px-3 py-2">Dibatalkan</span>
                        @else
                            <span class="badge bg-info px-3 py-2">Selesai</span>
                        @endif
                        
                        @if($reservation->payment_status == 'unpaid')
                            <span class="badge bg-danger px-3 py-2 ms-2">Belum Bayar</span>
                        @elseif($reservation->payment_status == 'partial')
                            <span class="badge bg-warning px-3 py-2 ms-2">DP Dibayar</span>
                        @else
                            <span class="badge bg-success px-3 py-2 ms-2">Lunas</span>
                        @endif
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <h6 class="fw-bold">Informasi Customer</h6>
                            <table class="table table-borderless">
                                <tr>
                                    <th style="width: 100px;">Nama</th>
                                    <td>{{ $reservation->customer_name }}</td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td>{{ $reservation->customer_email }}</td>
                                </tr>
                                <tr>
                                    <th>Telepon</th>
                                    <td>{{ $reservation->customer_phone }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6 mb-3">
                            <h6 class="fw-bold">Informasi Reservasi</h6>
                            <table class="table table-borderless">
                                <tr>
                                    <th style="width: 100px;">Tanggal</th>
                                    <td>{{ \Carbon\Carbon::parse($reservation->reservation_date)->format('d F Y') }}</td>
                                </tr>
                                <tr>
                                    <th>Jam</th>
                                    <td>{{ $reservation->reservation_time }}</td>
                                </tr>
                                <tr>
                                    <th>Jumlah Tamu</th>
                                    <td>{{ $reservation->number_of_guests }} orang</td>
                                </tr>
                                @if($reservation->special_requests)
                                <tr>
                                    <th>Request</th>
                                    <td>{{ $reservation->special_requests }}</td>
                                </tr>
                                @endif
                            </table>
                        </div>
                    </div>
                    
                    <div class="alert alert-info">
                        <strong>DP yang harus dibayar:</strong> Rp {{ number_format($reservation->down_payment, 0, ',', '.') }}
                    </div>
                    
                    @if($reservation->status == 'pending')
                    <div class="alert alert-warning">
                        <i class="fas fa-clock me-2"></i>
                        Reservasi Anda sedang menunggu konfirmasi. Silakan lakukan pembayaran DP untuk mengkonfirmasi reservasi.
                    </div>
                    
                    <div class="text-center mt-4">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#paymentModal">
                            <i class="fas fa-upload me-2"></i> Upload Bukti Pembayaran
                        </button>
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#cancelModal">
                            <i class="fas fa-times me-2"></i> Batalkan Reservasi
                        </button>
                    </div>
                    @endif
                    
                    @if($reservation->cancellation_reason)
                    <div class="alert alert-danger mt-3">
                        <strong>Alasan Pembatalan:</strong> {{ $reservation->cancellation_reason }}
                    </div>
                    @endif
                    
                    <div class="text-center mt-4">
                        <a href="{{ route('branding.home') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Upload Pembayaran -->
<div class="modal fade" id="paymentModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Upload Bukti Pembayaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('reservation.payment.upload') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="booking_code" value="{{ $reservation->booking_code }}">
                <input type="hidden" name="amount" value="{{ $reservation->down_payment }}">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Metode Pembayaran</label>
                        <select name="payment_method" class="form-control" required>
                            <option value="transfer">Transfer Bank</option>
                            <option value="credit_card">Kartu Kredit</option>
                            <option value="e_wallet">E-Wallet</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Upload Bukti</label>
                        <input type="file" name="payment_proof" class="form-control" accept="image/*" required>
                        <small class="text-muted">Format: JPG, PNG, PDF. Max 2MB</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Upload</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Batalkan Reservasi -->
<div class="modal fade" id="cancelModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Batalkan Reservasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('reservation.table.cancel', $reservation->booking_code) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Alasan Pembatalan</label>
                        <textarea name="reason" class="form-control" rows="3" required></textarea>
                    </div>
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Reservasi yang dibatalkan tidak dapat dikembalikan.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-danger">Batalkan Reservasi</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection