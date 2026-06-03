@extends('layouts.admin')

@section('title', 'Laporan Pemasukan')

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

    .report-main-card .card-header {
        background: transparent;
        border-bottom: 1px solid #f0f0f0;
        padding: 18px 24px;
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

    .summary-card.primary   { background: linear-gradient(135deg, #1c3451, #2a4a6b); }
    .summary-card.success   { background: linear-gradient(135deg, #15803d, #16a34a); }
    .summary-card.info      { background: linear-gradient(135deg, #0369a1, #0284c7); }

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
        background: #f1f5f9;
        color: #1c3451;
        border: none;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 600;
        padding: 8px 16px;
        transition: all 0.2s;
    }

    .btn-back:hover {
        background: #e2e8f0;
        color: #1c3451;
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
</style>
@endpush

@section('content')

{{-- Header --}}
<div class="report-page-header">
    <div class="d-flex align-items-center">
        <div class="header-icon">
            <i class="fas fa-money-bill-wave"></i>
        </div>
        <h6>Laporan Pemasukan</h6>
    </div>
    <div class="d-flex gap-2">
        <form action="{{ route('admin.reports.export-income') }}" method="GET" class="d-inline">
            <input type="hidden" name="start_date" value="{{ request('start_date') }}">
            <input type="hidden" name="end_date" value="{{ request('end_date') }}">
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
                    <label class="form-label">Tipe Transaksi</label>
                    <select name="payment_type" class="form-control">
                        <option value="">Semua</option>
                        <option value="down_payment" {{ request('payment_type') == 'down_payment' ? 'selected' : '' }}>Down Payment (Reservasi)</option>
                        <option value="full_payment" {{ request('payment_type') == 'full_payment' ? 'selected' : '' }}>Full Payment (Tiket)</option>
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
            <div class="col-md-4">
                <div class="card summary-card primary text-white">
                    <div class="card-body">
                        <h6>Total Pemasukan</h6>
                        <h3>Rp {{ number_format($summary['total_income'], 0, ',', '.') }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card summary-card success text-white">
                    <div class="card-body">
                        <h6>Dari Tiket Kolam</h6>
                        <h3>Rp {{ number_format($summary['ticket_income'], 0, ',', '.') }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card summary-card info text-white">
                    <div class="card-body">
                        <h6>Dari Reservasi (DP)</h6>
                        <h3>Rp {{ number_format($summary['reservation_income'], 0, ',', '.') }}</h3>
                    </div>
                </div>
            </div>
        </div>

        {{-- Charts --}}
        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <div class="card chart-card">
                    <div class="card-body">
                        <h6 class="text-center">Perbandingan Pemasukan</h6>
                        <canvas id="incomeComparisonChart" height="250"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card chart-card">
                    <div class="card-body">
                        <h6 class="text-center">Tren Pemasukan Harian</h6>
                        <canvas id="dailyIncomeChart" height="250"></canvas>
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
                        <th>Tanggal</th>
                        <th>Tipe</th>
                        <th>Metode</th>
                        <th>Jumlah</th>
                        <th>Status</th>
                        <th>Kode Transaksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($payments as $index => $payment)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ \Carbon\Carbon::parse($payment->created_at)->format('d/m/Y H:i') }}</td>
                        <td>
                            @if($payment->payment_type == 'down_payment')
                                <span class="badge bg-warning">DP Reservasi</span>
                            @else
                                <span class="badge bg-success">Full Payment Tiket</span>
                            @endif
                        </td>
                        <td>
                            @if($payment->payment_method == 'transfer')
                                <i class="fas fa-university me-1"></i> Transfer
                            @elseif($payment->payment_method == 'credit_card')
                                <i class="fas fa-credit-card me-1"></i> Kartu Kredit
                            @else
                                <i class="fas fa-wallet me-1"></i> E-Wallet
                            @endif
                        </td>
                        <td class="fw-bold">Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                        <td>{!! $payment->payment_status_label !!}</td>
                        <td><small>{{ $payment->payment_code }}</small></td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">Tidak ada data pemasukan</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-between align-items-center mt-3">
            <form action="{{ route('admin.reports.export-income') }}" method="GET" class="d-inline">
                <input type="hidden" name="start_date" value="{{ request('start_date') }}">
                <input type="hidden" name="end_date" value="{{ request('end_date') }}">
                <input type="hidden" name="payment_type" value="{{ request('payment_type') }}">
                <button type="submit" class="btn btn-export btn-sm">
                    <i class="fas fa-file-excel me-1"></i> Export Excel
                </button>
            </form>
            {{ $payments->links() }}
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const comparisonCtx = document.getElementById('incomeComparisonChart').getContext('2d');
    new Chart(comparisonCtx, {
        type: 'pie',
        data: {
            labels: ['Tiket Kolam', 'Reservasi (DP)'],
            datasets: [{
                data: [{{ $summary['ticket_income'] }}, {{ $summary['reservation_income'] }}],
                backgroundColor: ['#15803d', '#c1a067']
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { position: 'bottom' } }
        }
    });

    const dailyCtx = document.getElementById('dailyIncomeChart').getContext('2d');
    new Chart(dailyCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode($dailyLabels ?? []) !!},
            datasets: [{
                label: 'Pemasukan (Rp)',
                data: {!! json_encode($dailyData ?? []) !!},
                borderColor: '#c1a067',
                backgroundColor: 'rgba(193,160,103,0.1)',
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + value.toLocaleString('id-ID');
                        }
                    }
                }
            }
        }
    });
</script>
@endpush