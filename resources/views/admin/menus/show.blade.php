@extends('layouts.admin')

@section('title', 'Detail Menu')

@section('content')
<div class="card">
    <div class="card-header bg-white px-4 py-3 d-flex justify-content-between align-items-center"
         style="border-bottom: 2px solid #f0ebe0;">
        <h6 class="mb-0 fw-bold" style="color: #1c3451;">
            <i class="fas fa-info-circle me-2" style="color: #c1a067;"></i>Detail Menu: {{ $menu->name }}
        </h6>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.menus.edit', $menu) }}" class="btn btn-admin-edit btn-sm">
                <i class="fas fa-edit me-1"></i>Edit
            </a>
            <a href="{{ route('admin.menus.index') }}" class="btn btn-admin-back btn-sm">
                <i class="fas fa-arrow-left me-1"></i>Kembali
            </a>
        </div>
    </div>
    <div class="card-body px-4 py-4">
        <div class="row">
            <div class="col-md-4 text-center mb-4 mb-md-0">
                @if($menu->image)
                    <img src="{{ asset('storage/' . $menu->image) }}"
                         class="img-fluid rounded-3"
                         style="max-width: 100%; border: 3px solid #e8e0d0;">
                @else
                    <div class="d-flex align-items-center justify-content-center rounded-3"
                         style="height: 200px; background: #f0ebe0;">
                        <i class="fas fa-utensils fa-4x" style="color: #c1a067; opacity: 0.5;"></i>
                    </div>
                @endif
            </div>
            <div class="col-md-8">
                <table class="table table-borderless detail-table">
                    <tr>
                        <th>Nama Menu</th>
                        <td>{{ $menu->name }}</td>
                    </tr>
                    <tr>
                        <th>Kategori</th>
                        <td>
                            <span class="badge-category">{{ ucfirst($menu->category) }}</span>
                        </td>
                    </tr>
                    <tr>
                        <th>Harga</th>
                        <td class="fw-bold" style="color: #c1a067;">
                            Rp {{ number_format($menu->price, 0, ',', '.') }}
                        </td>
                    </tr>
                    <tr>
                        <th>Deskripsi</th>
                        <td class="text-muted">{{ $menu->description }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>{!! $menu->status_label !!}</td>
                    </tr>
                    <tr>
                        <th>Rekomendasi</th>
                        <td>
                            @if($menu->is_recommended)
                                <span class="badge" style="background: #f0fdf4; color: #15803d; border: 1px solid #bbf7d0; border-radius: 20px; padding: 4px 12px; font-size: 12px;">Ya</span>
                            @else
                                <span class="badge" style="background: #f9fafb; color: #6b7280; border: 1px solid #e5e7eb; border-radius: 20px; padding: 4px 12px; font-size: 12px;">Tidak</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Dibuat Pada</th>
                        <td class="text-muted">{{ $menu->created_at->format('d M Y H:i') }}</td>
                    </tr>
                    <tr>
                        <th>Terakhir Update</th>
                        <td class="text-muted">{{ $menu->updated_at->format('d M Y H:i') }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .btn-admin-edit {
        background: #fef9ec;
        color: #c1a067;
        border: 1.5px solid #e8d9b8;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
        padding: 6px 16px;
        transition: all 0.2s;
    }

    .btn-admin-edit:hover {
        background: #c1a067;
        color: white;
        border-color: #c1a067;
    }

    .btn-admin-back {
        background: white;
        color: #6b7280;
        border: 1.5px solid #e5e7eb;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
        padding: 6px 16px;
        transition: all 0.2s;
    }

    .btn-admin-back:hover {
        background: #1c3451;
        color: white;
        border-color: #1c3451;
    }

    .detail-table th {
        width: 150px;
        font-size: 13px;
        font-weight: 600;
        color: #6b7280;
        padding: 10px 0;
        vertical-align: top;
    }

    .detail-table td {
        font-size: 14px;
        color: #1c3451;
        padding: 10px 0;
        border-bottom: 1px solid #f5f5f5;
    }

    .detail-table tr:last-child td {
        border-bottom: none;
    }

    .badge-category {
        background: #eef2ff;
        color: #1c3451;
        border-radius: 20px;
        padding: 4px 12px;
        font-size: 12px;
        font-weight: 500;
    }
</style>
@endpush