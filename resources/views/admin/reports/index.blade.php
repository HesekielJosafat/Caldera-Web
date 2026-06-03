@extends('layouts.admin')

@section('title', 'Reports')

@section('content')
<div class="row g-4">
    <div class="col-md-4">
        <div class="card h-100 report-card">
            <div class="card-body text-center p-4">
                <div class="report-icon-wrap mb-3" style="background: #eef2ff;">
                    <i class="fas fa-ticket-alt fa-2x" style="color: #1c3451;"></i>
                </div>
                <h5 class="fw-bold mb-2" style="color: #1c3451;">Laporan Tiket Kolam</h5>
                <p class="text-muted small mb-4">Lihat laporan penjualan tiket kolam</p>
                <a href="{{ route('admin.reports.tickets') }}" class="btn btn-report">
                    <i class="fas fa-chart-line me-1"></i>Lihat Laporan
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card h-100 report-card">
            <div class="card-body text-center p-4">
                <div class="report-icon-wrap mb-3" style="background: #f0fdf4;">
                    <i class="fas fa-calendar-check fa-2x" style="color: #15803d;"></i>
                </div>
                <h5 class="fw-bold mb-2" style="color: #1c3451;">Laporan Reservasi</h5>
                <p class="text-muted small mb-4">Lihat laporan reservasi meja</p>
                <a href="{{ route('admin.reports.reservations') }}" class="btn btn-report">
                    <i class="fas fa-chart-line me-1"></i>Lihat Laporan
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card h-100 report-card">
            <div class="card-body text-center p-4">
                <div class="report-icon-wrap mb-3" style="background: #fdf8f0;">
                    <i class="fas fa-money-bill-wave fa-2x" style="color: #c1a067;"></i>
                </div>
                <h5 class="fw-bold mb-2" style="color: #1c3451;">Laporan Pemasukan</h5>
                <p class="text-muted small mb-4">Lihat laporan pendapatan</p>
                <a href="{{ route('admin.reports.income') }}" class="btn btn-report">
                    <i class="fas fa-chart-line me-1"></i>Lihat Laporan
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .report-card {
        border-top: 3px solid #c1a067 !important;
        border-radius: 16px !important;
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .report-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 28px rgba(28,52,81,0.1) !important;
    }

    .report-icon-wrap {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
    }

    .btn-report {
        background: #1c3451;
        color: white;
        border: none;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 600;
        padding: 9px 22px;
        transition: all 0.2s;
        width: 100%;
    }

    .btn-report:hover {
        background: #c1a067;
        color: white;
        transform: translateY(-1px);
    }
</style>
@endpush