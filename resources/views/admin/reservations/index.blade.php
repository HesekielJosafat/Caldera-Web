@extends('layouts.admin')

@section('title', 'Reservations')

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

    .btn-export {
        background: #15803d;
        color: #fff;
        border: none;
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

    .btn-export:hover {
        background: #16a34a;
        color: #fff;
    }

    .report-main-card {
        border: none;
        border-radius: 16px;
        border-top: 3px solid #c1a067 !important;
        box-shadow: 0 4px 20px rgba(28,52,81,0.08);
    }

    .report-main-card .card-body {
        padding: 24px;
    }

    .filter-section {
        background: #f8fafc;
        border-radius: 14px;
        padding: 16px 20px;
        margin-bottom: 24px;
        border: 1px solid #e8edf2;
    }

    .filter-section .form-control,
    .filter-section .form-select {
        border-radius: 10px;
        border: 1px solid #dde2e8;
        font-size: 13px;
        padding: 8px 13px;
        color: #1c3451;
    }

    .filter-section .form-control:focus,
    .filter-section .form-select:focus {
        border-color: #c1a067;
        box-shadow: 0 0 0 3px rgba(193,160,103,0.15);
    }

    .report-table thead th {
        background: #1c3451;
        color: #fff;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.4px;
        padding: 12px 14px;
        border: none;
    }

    .report-table thead th:first-child { border-radius: 10px 0 0 0; }
    .report-table thead th:last-child { border-radius: 0 10px 0 0; }

    .report-table tbody tr { transition: background 0.15s; }
    .report-table tbody tr:hover { background: #f8fafc; }

    .report-table tbody td {
        font-size: 13px;
        color: #374151;
        padding: 12px 14px;
        vertical-align: middle;
        border-bottom: 1px solid #f0f0f0;
    }

    .report-table tbody td.fw-bold { color: #1c3451; }

    .btn-view {
        background: #1c3451;
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: 5px 10px;
        font-size: 12px;
        transition: all 0.2s;
    }

    .btn-view:hover { background: #c1a067; color: #fff; }

    .btn-confirm {
        background: #15803d;
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: 5px 10px;
        font-size: 12px;
        transition: all 0.2s;
    }

    .btn-confirm:hover { background: #16a34a; color: #fff; }

    .btn-verify {
        background: #c1a067;
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: 5px 10px;
        font-size: 12px;
        transition: all 0.2s;
    }

    .btn-verify:hover { background: #a8894f; color: #fff; }

    .btn-cancel-row {
        background: #d97706;
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: 5px 10px;
        font-size: 12px;
        transition: all 0.2s;
    }

    .btn-cancel-row:hover { background: #b45309; color: #fff; }

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
        max-height: 300px;
        border-radius: 8px;
        cursor: pointer;
        transition: transform 0.2s;
    }

    .proof-preview:hover { transform: scale(1.02); }
</style>
@endpush

@section('content')

<div class="report-page-header">
    <div class="d-flex align-items-center">
        <div class="header-icon">
            <i class="fas fa-calendar-check"></i>
        </div>
        <h6>Daftar Reservasi</h6>
    </div>
    <a href="{{ route('admin.reservations.export') }}" class="btn-export">
        <i class="fas fa-download"></i> Export
    </a>
</div>

<div class="card report-main-card">
    <div class="card-body">

        <div class="filter-section">
            <div class="row g-2">
                <div class="col-md-3">
                    <select class="form-select" id="statusFilter" onchange="filterReservations()">
                        <option value="">Semua Status</option>
                        <option value="pending">Pending</option>
                        <option value="confirmed">Confirmed</option>
                        <option value="cancelled">Cancelled</option>
                        <option value="completed">Completed</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-select" id="paymentFilter" onchange="filterReservations()">
                        <option value="">Semua Pembayaran</option>
                        <option value="waiting_payment">Menunggu Pembayaran</option>
                        <option value="payment_verified">Menunggu Verifikasi</option>
                        <option value="paid">Lunas</option>
                        <option value="unpaid">Belum Bayar</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="date" class="form-control" id="dateFilter" onchange="filterReservations()">
                </div>
                <div class="col-md-3">
                    <input type="text" class="form-control" id="searchFilter" placeholder="Cari nama atau kode booking..." onkeyup="filterReservations()">
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table report-table" id="reservationsTable">
                <thead>
                    <tr>
                        <th>Kode Booking</th>
                        <th>Customer</th>
                        <th>Tanggal</th>
                        <th>Jam</th>
                        <th>Tamu</th>
                        <th>DP</th>
                        <th>Status Reservasi</th>
                        <th>Status Bayar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reservations as $reservation)
                    <tr data-status="{{ $reservation->status }}" 
                        data-payment="{{ $reservation->payment_status }}"
                        data-date="{{ \Carbon\Carbon::parse($reservation->reservation_date)->format('Y-m-d') }}">
                        <td class="fw-bold">{{ $reservation->booking_code }}</td>
                        <td>
                            {{ $reservation->customer_name }}<br>
                            <small class="text-muted">{{ $reservation->customer_phone }}</small>
                        </td>
                        <td>{{ \Carbon\Carbon::parse($reservation->reservation_date)->format('d M Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($reservation->reservation_time)->format('H:i') }}</td>
                        <td>{{ $reservation->number_of_guests }} orang</td>
                        <td>Rp {{ number_format($reservation->down_payment ?? 50000, 0, ',', '.') }}</td>
                        <td>{!! $reservation->status_label !!}</td>
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
                            @endphp
                            <span class="payment-badge {{ $paymentClass }}">
                                <i class="fas 
                                    @if($reservation->payment_status == 'waiting_payment') fa-clock
                                    @elseif($reservation->payment_status == 'payment_verified') fa-upload
                                    @elseif($reservation->payment_status == 'paid') fa-check-circle
                                    @else fa-times-circle
                                    @endif me-1"></i>
                                {{ $paymentText }}
                            </span>
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('admin.reservations.show', $reservation) }}" class="btn btn-view" title="Lihat Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                
                                @if($reservation->payment_status == 'payment_verified' && $reservation->status == 'pending')
                                    <button onclick="showVerifyPaymentModal({{ $reservation->id }}, '{{ $reservation->booking_code }}', '{{ $reservation->payment_proof }}')" 
                                            class="btn btn-verify" title="Verifikasi Pembayaran">
                                        <i class="fas fa-credit-card"></i>
                                    </button>
                                @endif
                                
                                @if($reservation->status == 'pending')
                                    <button onclick="showCancelModal({{ $reservation->id }})" class="btn btn-cancel-row" title="Batalkan Reservasi">
                                        <i class="fas fa-times"></i>
                                    </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center text-muted py-4">Belum ada data reservasi</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $reservations->links() }}
        </div>

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
    
    function filterReservations() {
        const status = document.getElementById('statusFilter').value.toLowerCase();
        const payment = document.getElementById('paymentFilter').value.toLowerCase();
        const date = document.getElementById('dateFilter').value;
        const search = document.getElementById('searchFilter').value.toLowerCase();
        const rows = document.querySelectorAll('#reservationsTable tbody tr');
        
        rows.forEach(row => {
            if (row.cells.length < 9) return;
            
            let show = true;
            const rowStatus = row.getAttribute('data-status') || '';
            const rowPayment = row.getAttribute('data-payment') || '';
            const rowDate = row.getAttribute('data-date') || '';
            
            if (status && rowStatus !== status) show = false;
            if (payment && rowPayment !== payment) show = false;
            if (date && rowDate !== date) show = false;
            if (search && show) {
                const text = row.innerText.toLowerCase();
                if (!text.includes(search)) show = false;
            }
            row.style.display = show ? '' : 'none';
        });
    }
    
    document.getElementById('verifyPaymentModal').addEventListener('hidden.bs.modal', function() {
        if (currentReservationId) {
            location.reload();
        }
    });
</script>
@endpush

@endsection