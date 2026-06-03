@extends('layouts.admin')

@section('title', 'Promo Management')

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

    .btn-add {
        background: #c1a067;
        color: #fff;
        border: none;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 600;
        padding: 8px 18px;
        transition: all 0.2s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .btn-add:hover {
        background: #a98750;
        color: #fff;
        transform: translateY(-1px);
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

    /* Table */
    .report-main-card .table thead th {
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #6b7280;
        border-bottom: 2px solid #f0f0f0;
        padding: 12px 16px;
        white-space: nowrap;
    }

    .report-main-card .table tbody td {
        padding: 14px 16px;
        vertical-align: middle;
        font-size: 13px;
        color: #374151;
        border-bottom: 1px solid #f8f9fa;
    }

    .report-main-card .table tbody tr:hover {
        background: #f8fafc;
    }

    .promo-thumb {
        width: 64px;
        height: 44px;
        object-fit: cover;
        border-radius: 8px;
        border: 2px solid #f0f0f0;
    }

    .promo-thumb-fallback {
        width: 64px;
        height: 44px;
        background: #f0f0f0;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #9ca3af;
        font-size: 18px;
    }

    .badge-promo-code {
        background: rgba(193,160,103,0.15);
        color: #a98750;
        font-weight: 700;
        font-size: 11px;
        padding: 4px 10px;
        border-radius: 6px;
        letter-spacing: 0.5px;
    }

    .badge-active {
        background: rgba(21,128,61,0.12);
        color: #15803d;
        font-size: 11px;
        font-weight: 600;
        padding: 4px 10px;
        border-radius: 6px;
    }

    .badge-inactive {
        background: rgba(107,114,128,0.12);
        color: #6b7280;
        font-size: 11px;
        font-weight: 600;
        padding: 4px 10px;
        border-radius: 6px;
    }

    .badge-expired {
        background: rgba(220,38,38,0.1);
        color: #dc2626;
        font-size: 11px;
        font-weight: 600;
        padding: 4px 10px;
        border-radius: 6px;
    }

    .badge-upcoming {
        background: rgba(37,99,235,0.1);
        color: #2563eb;
        font-size: 11px;
        font-weight: 600;
        padding: 4px 10px;
        border-radius: 6px;
    }

    .btn-action-edit {
        background: #1c3451;
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: 5px 10px;
        font-size: 12px;
        transition: all 0.2s;
    }

    .btn-action-edit:hover { background: #c1a067; color: #fff; }

    .btn-action-delete {
        background: #dc2626;
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: 5px 10px;
        font-size: 12px;
        transition: all 0.2s;
    }

    .btn-action-delete:hover { background: #b91c1c; color: #fff; }

    .period-text {
        font-size: 12px;
        color: #6b7280;
        line-height: 1.6;
    }

    .discount-value {
        font-weight: 700;
        color: #1c3451;
        font-size: 14px;
    }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #9ca3af;
    }

    .empty-state i { color: #dde2e8; margin-bottom: 16px; display: block; }
    .empty-state p { font-size: 14px; margin-bottom: 16px; }
</style>
@endpush

@section('content')

<div class="report-page-header">
    <div class="d-flex align-items-center">
        <div class="header-icon">
            <i class="fas fa-tags"></i>
        </div>
        <h6>Daftar Promo</h6>
    </div>
    <a href="{{ route('admin.promos.create') }}" class="btn-add">
        <i class="fas fa-plus"></i> Tambah Promo
    </a>
</div>

<div class="card report-main-card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Gambar</th>
                        <th>Judul</th>
                        <th>Kode Promo</th>
                        <th>Diskon</th>
                        <th>Periode</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($promos as $promo)
                    <tr>
                        <td>
                            @if($promo->banner_image)
                                <img src="{{ asset('storage/' . $promo->banner_image) }}"
                                     class="promo-thumb"
                                     onerror="this.parentElement.innerHTML='<div class=\'promo-thumb-fallback\'><i class=\'fas fa-image\'></i></div>'">
                            @else
                                <div class="promo-thumb-fallback">
                                    <i class="fas fa-image"></i>
                                </div>
                            @endif
                        </td>
                        <td class="fw-bold" style="color:#1c3451;">{{ $promo->title }}</td>
                        <td><span class="badge-promo-code">{{ $promo->promo_code }}</span></td>
                        <td>
                            <span class="discount-value">
                                @if($promo->discount_type == 'percentage')
                                    {{ $promo->discount_value }}%
                                @else
                                    Rp {{ number_format($promo->discount_value, 0, ',', '.') }}
                                @endif
                            </span>
                        </td>
                        <td>
                            <div class="period-text">
                                {{ \Carbon\Carbon::parse($promo->start_date)->format('d M Y') }}<br>
                                s/d {{ \Carbon\Carbon::parse($promo->end_date)->format('d M Y') }}
                            </div>
                        </td>
                        <td>
                            @if($promo->is_active && now()->between($promo->start_date, $promo->end_date))
                                <span class="badge-active"><i class="fas fa-circle me-1" style="font-size:7px;"></i>Aktif</span>
                            @elseif(!$promo->is_active)
                                <span class="badge-inactive">Nonaktif</span>
                            @elseif(now()->gt($promo->end_date))
                                <span class="badge-expired">Berakhir</span>
                            @elseif(now()->lt($promo->start_date))
                                <span class="badge-upcoming">Akan Datang</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('admin.promos.edit', $promo) }}" class="btn btn-action-edit" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.promos.destroy', $promo) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-action-delete" title="Hapus"
                                            onclick="return confirm('Yakin hapus promo ini?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7">
                            <div class="empty-state">
                                <i class="fas fa-tags fa-4x"></i>
                                <p>Belum ada data promo</p>
                                <a href="{{ route('admin.promos.create') }}" class="btn-add">
                                    <i class="fas fa-plus"></i> Tambah Promo
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $promos->links() }}
        </div>
    </div>
</div>

@endsection