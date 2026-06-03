@extends('layouts.admin')

@section('title', 'Laporan Reservasi')

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

    .report-main-card {
        border: none;
        border-radius: 16px;
        border-top: 3px solid #c1a067 !important;
        box-shadow: 0 4px 20px rgba(28,52,81,0.08);
    }

    .report-main-card .card-body {
        padding: 24px;
    }

    .summary-card {
        border: none;
        border-radius: 14px;
        overflow: hidden;
        box-shadow: 0 4px 16px rgba(0,0,0,0.1);
        transition: transform 0.2s;
    }

    .summary-card:hover {
        transform: translateY(-3px);
    }

    .summary-card .card-body {
        padding: 20px 22px;
    }

    .summary-card h6 {
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        opacity: 0.9;
        margin-bottom: 8px;
    }

    .summary-card h3 {
        font-size: 22px;
        font-weight: 700;
        margin: 0;
    }

    .summary-card.primary { background: linear-gradient(135deg, #1c3451, #2a4a6b); }
    .summary-card.success { background: linear-gradient(135deg, #15803d, #16a34a); }
    .summary-card.warning { background: linear-gradient(135deg, #b45309, #d97706); }
    .summary-card.info    { background: linear-gradient(135deg, #0369a1, #0284c7); }

    .chart-card {
        border: none;
        border-radius: 14px;
        box-shadow: 0 2px 12px rgba(28,52,81,0.07);
    }

    .chart-card .card-body {
        padding: 20px;
    }

    .chart-card h6 {
        color: #1c3451;
        font-weight: 700;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 16px;
    }

    .filter-section {
        background: #f8fafc;
        border-radius: 14px;
        padding: 20px;
        margin-bottom: 24px;
        border: 1px solid #e8edf2;
    }

    .filter-section .form-label {
        font-size: 12px;
        font-weight: 600;
        color: #1c3451;
        text-transform: uppercase;
        letter-spacing: 0.4px;
        margin-bottom: 6px;
    }

    .filter-section .form-control,
    .filter-section .form-select {
        border-radius: 10px;
        border: 1px solid #dde2e8;
        font-size: 13px;
        padding: 9px 13px;
        color: #1c3451;
    }

    .filter-section .form-control:focus,
    .filter-section .form-select:focus {
        border-color: #c1a067;
        box-shadow: 0 0 0 3px rgba(193,160,103,0.15);
    }

    .btn-filter {
        background: #1c3451;
        color: #fff;
        border: none;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 600;
        padding: 10px 20px;
        transition: all 0.2s;
    }

    .btn-filter:hover {
        background: #c1a067;
        color: #fff;
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
    }

    .btn-export:hover {
        background: #16a34a;
        color: #fff;
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
    }

    .btn-back:hover {
        background: rgba(255,255,255,0.25);
        color: #fff;
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
    .report-table thead th:last-child  { border-radius: 0 10px 0 0; }

    .report-table tbody tr {
        transition: background 0.15s;
    }

    .report-table tbody tr:hover {
        background: #f8fafc;
    }

    .report-table tbody td {
        font-size: 13px;
        color: #374151;
        padding: 12px 14px;
        vertical-align: middle;
        border-bottom: 1px solid #f0f0f0;
    }

    .report-table tbody td.fw-bold {
        color: #1c3451;
    }

    .section-divider {
        height: 1px;
        background: linear-gradient(90deg, #c1a067 0%, transparent 100%);
        margin: 24px 0;
        border: none;
    }

    .btn-view {
        background: #1c3451;
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: 5px 10px;
        font-size: 12px;
        transition: all 0.2s;
    }

    .btn-view:hover {
        background: #c1a067;
        color: #fff;
    }
</style>
@endpush

@section('content')

{{-- Header --}}
<div class="report-page-header">
    <div class="d-flex align-items-center">
        <div class="header-icon">
            <i class="fas fa-calendar-check"></i>
        </div>
        <h6>Laporan Reservasi Meja</h6>
    </div>
    <div class="d-flex gap-2">
        <form action="{{ route('admin.reports.export-reservations') }}" method="GET" class="d-inline">
            <input type="hidden" name="start_date" value="{{ request('start_date') }}">
            <input type="hidden" name="end_date" value="{{ request('end_date') }}">
            <input type="hidden" name="status" value="{{ request('status') }}">
            <button type="submit" class="btn btn-export">
                <i class="fas fa-file-excel me-1"></i> Export Excel
            </button>
        </form>
        <a href="{{ route('admin.reports.index') }}" class="btn btn-back">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
    </div>
</div>

<div class="card report-main-card">
    <div class="card-body">

        {{-- Filter --}}
        <div class="filter-section">
            <form method="GET" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Tanggal Mulai</label>
                    <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Tanggal Selesai</label>
                    <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-control">
                        <option value="">Semua Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                    </select>
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-filter w-100">
                        <i class="fas fa-filter me-1"></i> Filter
                    </button>
                </div>
            </form>
        </div>

        {{-- Summary Cards --}}
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="card summary-card primary text-white">
                    <div class="card-body">
                        <h6>Total Reservasi</h6>
                        <h3>{{ $summary['total'] }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card summary-card success text-white">
                    <div class="card-body">
                        <h6>Confirmed</h6>
                        <h3>{{ $summary['confirmed'] }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card summary-card warning text-white">
                    <div class="card-body">
                        <h6>Pending</h6>
                        <h3>{{ $summary['pending'] }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card summary-card info text-white">
                    <div class="card-body">
                        <h6>Total Tamu</h6>
                        <h3>{{ $summary['total_guests'] }}</h3>
                    </div>
                </div>
            </div>
        </div>

        {{-- Chart --}}
        <div class="row g-3 mb-4">
            <div class="col-12">
                <div class="card chart-card">
                    <div class="card-body">
                        <canvas id="reservationsChart" height="300"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <hr class="section-divider">

        {{-- Table --}}
        <div class="table-responsive">
            <table class="table report-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Booking</th>
                        <th>Customer</th>
                        <th>Tanggal</th>
                        <th>Jam</th>
                        <th>Tamu</th>
                        <th>DP</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reservations as $index => $reservation)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td class="fw-bold">{{ $reservation->booking_code }}</td>
                        <td>
                            {{ $reservation->customer_name }}<br>
                            <small class="text-muted">{{ $reservation->customer_phone }}</small>
                        </td>
                        <td>{{ \Carbon\Carbon::parse($reservation->reservation_date)->format('d/m/Y') }}</td>
                        <td>{{ $reservation->reservation_time }}</td>
                        <td>{{ $reservation->number_of_guests }} orang</td>
                        <td>Rp {{ number_format($reservation->down_payment ?? 0, 0, ',', '.') }}</td>
                        <td>{!! $reservation->status_label !!}</td>
                        <td>
                            <a href="{{ route('admin.reservations.show', $reservation) }}" class="btn btn-view">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center text-muted py-4">Tidak ada data reservasi</td>
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
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('reservationsChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($chartLabels ?? []) !!},
            datasets: [{
                label: 'Jumlah Reservasi',
                data: {!! json_encode($chartData ?? []) !!},
                backgroundColor: 'rgba(28,52,81,0.5)',
                borderColor: '#1c3451',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            scales: {
                y: {
                    beginAtZero: true,
                    title: { display: true, text: 'Jumlah Reservasi' }
                },
                x: {
                    title: { display: true, text: 'Tanggal' }
                }
            }
        }
    });
</script>
@endpush