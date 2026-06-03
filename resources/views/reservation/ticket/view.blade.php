@extends('layouts.app')

@section('title', 'Detail Tiket')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-lg">
                <div class="card-header bg-transparent text-center pt-4">
                    <h4 class="fw-bold mb-2">Detail Tiket Kolam</h4>
                    <p class="text-muted">Kode Tiket: <strong>{{ $ticket->ticket_code }}</strong></p>
                </div>
                <div class="card-body p-4">
                    <div class="text-center mb-4">
                        @if($ticket->status == 'active')
                            <span class="badge bg-success px-3 py-2">Aktif</span>
                        @elseif($ticket->status == 'used')
                            <span class="badge bg-secondary px-3 py-2">Sudah Digunakan</span>
                        @else
                            <span class="badge bg-danger px-3 py-2">Kadaluarsa</span>
                        @endif
                        
                        @if($ticket->payment_status == 'paid')
                            <span class="badge bg-success px-3 py-2 ms-2">Lunas</span>
                        @else
                            <span class="badge bg-warning px-3 py-2 ms-2">Belum Bayar</span>
                        @endif
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <h6 class="fw-bold">Informasi Customer</h6>
                            <table class="table table-borderless">
                                <tr>
                                    <th style="width: 100px;">Nama</th>
                                    <td>{{ $ticket->customer_name }}</td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td>{{ $ticket->customer_email }}</td>
                                </tr>
                                <tr>
                                    <th>Telepon</th>
                                    <td>{{ $ticket->customer_phone }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6 mb-3">
                            <h6 class="fw-bold">Informasi Tiket</h6>
                            <table class="table table-borderless">
                                <tr>
                                    <th style="width: 100px;">Tanggal</th>
                                    <td>{{ \Carbon\Carbon::parse($ticket->visit_date)->format('d F Y') }}</td>
                                </tr>
                                <tr>
                                    <th>Jenis Tiket</th>
                                    <td>{{ ucfirst($ticket->ticket_type) }}</td>
                                </tr>
                                <tr>
                                    <th>Jumlah</th>
                                    <td>{{ $ticket->number_of_tickets }} tiket</td>
                                </tr>
                                <tr>
                                    <th>Total</th>
                                    <td>Rp {{ number_format($ticket->total_amount, 0, ',', '.') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    
                    @if($ticket->status == 'active' && $ticket->payment_status == 'paid')
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle me-2"></i>
                        Tiket Anda siap digunakan. Tunjukkan kode ini saat masuk ke area kolam renang.
                    </div>
                    @elseif($ticket->payment_status == 'unpaid')
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Silakan lakukan pembayaran untuk mengaktifkan tiket Anda.
                    </div>
                    <div class="text-center mt-3">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#paymentModal">
                            <i class="fas fa-upload me-2"></i> Upload Bukti Pembayaran
                        </button>
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
                <input type="hidden" name="booking_code" value="{{ $ticket->ticket_code }}">
                <input type="hidden" name="amount" value="{{ $ticket->total_amount }}">
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
@endsection