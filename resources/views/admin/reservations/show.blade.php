@extends('layouts.admin')

@section('title', 'Detail Reservasi')

@push('styles')
<style>
    .report-page-header {
        background: linear-gradient(135deg, #1c3451 0%, #2a4a6b 100%);
        border-radius: 16px;
        padding: 24px 28px;
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .report-page-header h6 {
        color: #fff;
        font-size: 18px;
        font-weight: 700;
        margin: 0;
    }

    .report-page-header .header-icon {
        width: 44px;
        height: 44px;
        background: rgba(193,160,103,0.2);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 14px;
    }

    .report-page-header .header-icon i {
        color: #c1a067;
        font-size: 18px;
    }

    .booking-code-badge {
        background: rgba(193,160,103,0.2);
        color: #c1a067;
        border: 1px solid rgba(193,160,103,0.4);
        border-radius: 8px;
        font-size: 13px;
        font-weight: 700;
        padding: 5px 14px;
        letter-spacing: 0.5px;
    }

    .btn-back {
        background: rgba(255,255,255,0.15);
        color: #fff;
        border: 1px solid rgba(255,255,255,0.3);
        border-radius: 10px;
        font-size: 13px;
        font-weight: 600;
        padding: 8px 16px;
        transition: all 0.2s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .btn-back:hover {
        background: rgba(255,255,255,0.25);
        color: #fff;
    }

    .report-main-card {
        border: none;
        border-radius: 16px;
        border-top: 3px solid #c1a067 !important;
        box-shadow: 0 4px 20px rgba(28,52,81,0.08);
    }

    .report-main-card .card-body {
        padding: 28px;
    }

    .detail-section-title {
        font-size: 13px;
        font-weight: 700;
        color: #1c3451;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        padding-bottom: 10px;
        border-bottom: 2px solid #c1a067;
        margin-bottom: 16px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .detail-section-title i { color: #c1a067; font-size: 14px; }

    .detail-table { width: 100%; }

    .detail-table tr td:first-child {
        width: 160px;
        font-size: 12px;
        font-weight: 600;
        color: #6b7280;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        padding: 9px 0;
        vertical-align: middle;
    }

    .detail-table tr td:last-child {
        font-size: 14px;
        color: #1c3451;
        font-weight: 500;
        padding: 9px 0;
        vertical-align: middle;
    }

    .detail-table tr { border-bottom: 1px solid #f3f4f6; }
    .detail-table tr:last-child { border-bottom: none; }

    .section-divider {
        height: 1px;
        background: linear-gradient(90deg, #c1a067 0%, transparent 100%);
        margin: 24px 0;
        border: none;
    }

    /* Payment Status Badges */
    .payment-badge {
        display: inline-flex;
        align-items: center;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        gap: 4px;
    }

    .payment-waiting { background: #fff3e0; color: #e65100; }
    .payment-verified { background: #e3f2fd; color: #1565c0; }
    .payment-paid { background: #e8f5e9; color: #2e7d32; }
    .payment-unpaid { background: #ffebee; color: #c62828; }

    /* Buttons */
    .btn-confirm-main {
        background: linear-gradient(135deg, #15803d, #16a34a);
        color: #fff;
        border: none;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 600;
        padding: 10px 24px;
        transition: all 0.2s;
        box-shadow: 0 4px 12px rgba(21,128,61,0.3);
    }

    .btn-confirm-main:hover {
        background: linear-gradient(135deg, #166534, #15803d);
        color: #fff;
        transform: translateY(-1px);
    }

    .btn-verify-main {
        background: linear-gradient(135deg, #c1a067, #a8894f);
        color: #fff;
        border: none;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 600;
        padding: 10px 24px;
        transition: all 0.2s;
        box-shadow: 0 4px 12px rgba(193,160,103,0.3);
    }

    .btn-verify-main:hover {
        background: linear-gradient(135deg, #a8894f, #8b6d3f);
        color: #fff;
        transform: translateY(-1px);
    }

    .btn-cancel-main {
        background: linear-gradient(135deg, #d97706, #b45309);
        color: #fff;
        border: none;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 600;
        padding: 10px 24px;
        transition: all 0.2s;
        box-shadow: 0 4px 12px rgba(217,119,6,0.3);
    }

    .btn-cancel-main:hover {
        background: linear-gradient(135deg, #b45309, #92400e);
        color: #fff;
        transform: translateY(-1px);
    }

    /* Proof Image */
    .proof-image {
        max-width: 200px;
        border-radius: 8px;
        border: 1px solid #e8e0d0;
        cursor: pointer;
        transition: transform 0.2s;
    }

    .proof-image:hover {
        transform: scale(1.05);
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    /* Modal */
    .modal-content {
        border: none;
        border-radius: 16px;
        border-top: 3px solid #c1a067;
        box-shadow: 0 8px 32px rgba(28,52,81,0.15);
    }

    .modal-header {
        border-bottom: 1px solid #f0f0f0;
        padding: 18px 24px;
    }

    .modal-header .modal-title {
        font-size: 15px;
        font-weight: 700;
        color: #1c3451;
    }

    .modal-body { padding: 20px 24px; }
    .modal-footer { border-top: 1px solid #f0f0f0; padding: 16px 24px; }

    .modal-body .form-label {
        font-size: 12px;
        font-weight: 600;
        color: #1c3451;
        text-transform: uppercase;
        letter-spacing: 0.4px;
    }

    .modal-body .form-control {
        border-radius: 10px;
        border: 1px solid #dde2e8;
        font-size: 13px;
        color: #1c3451;
    }

    .modal-body .form-control:focus {
        border-color: #c1a067;
        box-shadow: 0 0 0 3px rgba(193,160,103,0.15);
    }

    .btn-modal-close {
        background: #f1f5f9;
        color: #1c3451;
        border: none;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 600;
        padding: 8px 16px;
        transition: all 0.2s;
    }

    .btn-modal-close:hover { background: #e2e8f0; color: #1c3451; }

    .btn-modal-danger {
        background: linear-gradient(135deg, #dc2626, #b91c1c);
        color: #fff;
        border: none;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 600;
        padding: 8px 18px;
        transition: all 0.2s;
    }

    .btn-modal-danger:hover { background: linear-gradient(135deg, #b91c1c, #991b1b); color: #fff; }

    .btn-modal-success {
        background: linear-gradient(135deg, #15803d, #16a34a);
        color: #fff;
        border: none;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 600;
        padding: 8px 18px;
        transition: all 0.2s;
    }

    .btn-modal-success:hover { background: linear-gradient(135deg, #16a34a, #15803d); color: #fff; }

    .proof-preview {
        max-width: 100%;
        max-height: 400px;
        border-radius: 8px;
        cursor: pointer;
    }
</style>
@endpush

@section('content')

<div class="report-page-header">
    <div class="d-flex align-items-center gap-3">
        <div class="header-icon">
            <i class="fas fa-calendar-check"></i>
        </div>
        <div>
            <h6>Detail Reservasi</h6>
        </div>
        <span class="booking-code-badge">{{ $reservation->booking_code }}</span>
    </div>
    <a href="{{ route('admin.reservations.index') }}" class="btn-back">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="card report-main-card">
    <div class="card-body">

        <div class="row g-4">
            {{-- Informasi Customer --}}
            <div class="col-md-6">
                <div class="detail-section-title">
                    <i class="fas fa-user"></i> Informasi Customer
                </div>
                <table class="detail-table">
                    <tr>
                        <td>Nama</td>
                        <td>{{ $reservation->customer_name }}</td>
                    </tr>
                    <tr>
                        <td>Telepon</td>
                        <td>{{ $reservation->customer_phone }}</td>
                    </tr>
                </table>
            </div>

            {{-- Informasi Reservasi --}}
            <div class="col-md-6">
                <div class="detail-section-title">
                    <i class="fas fa-info-circle"></i> Informasi Reservasi
                </div>
                <table class="detail-table">
                    <tr>
                        <td>Kode Booking</td>
                        <td><span class="fw-bold" style="color:#1c3451;">{{ $reservation->booking_code }}</span></td>
                    </tr>
                    <tr>
                        <td>Tanggal</td>
                        <td>{{ \Carbon\Carbon::parse($reservation->reservation_date)->format('d F Y') }}</td>
                    </tr>
                    <tr>
                        <td>Jam</td>
                        <td>{{ \Carbon\Carbon::parse($reservation->reservation_time)->format('H:i') }}</td>
                    </tr>
                    <tr>
                        <td>Jumlah Tamu</td>
                        <td>{{ $reservation->number_of_guests }} orang</td>
                    </tr>
                    <tr>
                        <td>Down Payment</td>
                        <td><span class="fw-bold" style="color:#c1a067; font-size:15px;">Rp {{ number_format($reservation->down_payment ?? 50000, 0, ',', '.') }}</span></td>
                    </tr>
                    <tr>
                        <td>Status Reservasi</td>
                        <td>{!! $reservation->status_label !!}</td>
                    </tr>
                    <tr>
                        <td>Status Pembayaran</td>
                        <td>
                            @php
                                $paymentClass = match($reservation->payment_status) {
                                    'waiting_payment' => 'payment-waiting',
                                    'payment_verified' => 'payment-verified',
                                    'paid' => 'payment-paid',
                                    default => 'payment-unpaid'
                                };
                                $paymentText = match($reservation->payment_status) {
                                    'waiting_payment' => 'Menunggu Pembayaran',
                                    'payment_verified' => 'Menunggu Verifikasi',
                                    'paid' => 'Lunas',
                                    default => 'Belum Bayar'
                                };
                                $paymentIcon = match($reservation->payment_status) {
                                    'waiting_payment' => 'fa-clock',
                                    'payment_verified' => 'fa-upload',
                                    'paid' => 'fa-check-circle',
                                    default => 'fa-times-circle'
                                };
                            @endphp
                            <span class="payment-badge {{ $paymentClass }}">
                                <i class="fas {{ $paymentIcon }} me-1"></i>
                                {{ $paymentText }}
                            </span>
                        </td>
                    </tr>
                    @if($reservation->special_requests)
                    <tr>
                        <td>Request Khusus</td>
                        <td>{{ $reservation->special_requests }}</td>
                    </tr>
                    @endif
                    @if($reservation->cancellation_reason)
                    <tr>
                        <td>Alasan Batal</td>
                        <td class="text-danger">{{ $reservation->cancellation_reason }}</td>
                    </tr>
                    @endif
                </table>
            </div>
        </div>

        {{-- Bukti Pembayaran (jika ada) --}}
        @if($reservation->payment_proof)
        <hr class="section-divider">
        <div class="detail-section-title">
            <i class="fas fa-receipt"></i> Bukti Pembayaran
        </div>
        <div class="text-center">
            <img src="{{ asset('storage/' . $reservation->payment_proof) }}" 
                 alt="Bukti Pembayaran" 
                 class="proof-image" 
                 style="max-width: 300px; cursor: pointer;"
                 onclick="openProofModal('{{ asset('storage/' . $reservation->payment_proof) }}')">
            <div class="mt-2">
                <small class="text-muted">Klik gambar untuk memperbesar</small>
            </div>
        </div>
        @endif

        {{-- Action Buttons --}}
        <hr class="section-divider">
        
        @if($reservation->payment_status == 'payment_verified' && $reservation->status == 'pending')
            <div class="text-end d-flex justify-content-end gap-2">
                <button onclick="showVerifyPaymentModal({{ $reservation->id }}, '{{ $reservation->booking_code }}', '{{ $reservation->payment_proof }}')" 
                        class="btn-verify-main">
                    <i class="fas fa-credit-card me-1"></i> Verifikasi Pembayaran
                </button>
                <button onclick="showCancelModal({{ $reservation->id }})" class="btn-cancel-main">
                    <i class="fas fa-times me-1"></i> Batalkan Reservasi
                </button>
            </div>
        @elseif($reservation->status == 'pending')
            <div class="text-end d-flex justify-content-end gap-2">
                <form action="{{ route('admin.reservations.confirm', $reservation) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn-confirm-main" onclick="return confirm('Konfirmasi reservasi ini?')">
                        <i class="fas fa-check me-1"></i> Konfirmasi Reservasi
                    </button>
                </form>
                <button onclick="showCancelModal({{ $reservation->id }})" class="btn-cancel-main">
                    <i class="fas fa-times me-1"></i> Batalkan Reservasi
                </button>
            </div>
        @endif

    </div>
</div>

<!-- Cancel Modal -->
<div class="modal fade" id="cancelModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Batalkan Reservasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="cancelForm" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Alasan Pembatalan</label>
                        <textarea name="cancellation_reason" class="form-control" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-modal-close" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-modal-danger">Batalkan Reservasi</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Verify Payment Modal -->
<div class="modal fade" id="verifyPaymentModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Verifikasi Pembayaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="verifyPaymentForm" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Kode Booking</label>
                        <input type="text" id="verifyBookingCode" class="form-control" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Bukti Pembayaran</label>
                        <div id="proofPreview" class="text-center">
                            <img id="proofImage" src="" alt="Bukti Pembayaran" class="proof-preview" style="display: none;">
                            <p id="noProofText" class="text-muted">Tidak ada bukti pembayaran</p>
                        </div>
                    </div>
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <small>Dengan memverifikasi pembayaran, reservasi akan otomatis dikonfirmasi dan customer akan menerima notifikasi.</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-modal-close" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-modal-success">
                        <i class="fas fa-check-circle me-2"></i> Verifikasi Pembayaran
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Proof Image Modal (Zoom) -->
<div class="modal fade" id="proofImageModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Bukti Pembayaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center p-4">
                <img id="proofFullImage" src="" alt="Bukti Pembayaran" style="max-width: 100%; max-height: 80vh;">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-modal-close" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    let currentReservationId = null;
    
    function showCancelModal(id) {
        const form = document.getElementById('cancelForm');
        form.action = `/admin/reservations/${id}/cancel`;
        new bootstrap.Modal(document.getElementById('cancelModal')).show();
    }
    
    function showVerifyPaymentModal(id, bookingCode, proofPath) {
        currentReservationId = id;
        const form = document.getElementById('verifyPaymentForm');
        form.action = `/admin/reservations/${id}/verify-payment`;
        
        document.getElementById('verifyBookingCode').value = bookingCode;
        
        const proofImage = document.getElementById('proofImage');
        const noProofText = document.getElementById('noProofText');
        
        if (proofPath) {
            proofImage.src = `/storage/${proofPath}`;
            proofImage.style.display = 'block';
            noProofText.style.display = 'none';
        } else {
            proofImage.style.display = 'none';
            noProofText.style.display = 'block';
        }
        
        new bootstrap.Modal(document.getElementById('verifyPaymentModal')).show();
    }
    
    function openProofModal(imageUrl) {
        document.getElementById('proofFullImage').src = imageUrl;
        new bootstrap.Modal(document.getElementById('proofImageModal')).show();
    }
    
    document.getElementById('verifyPaymentModal').addEventListener('hidden.bs.modal', function() {
        if (currentReservationId) {
            location.reload();
        }
    });
</script>
@endpush

@endsection