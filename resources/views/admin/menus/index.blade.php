@extends('layouts.admin')

@section('title', 'Menu Management')

@section('content')
<div class="card">
    <div class="card-header bg-white d-flex justify-content-between align-items-center py-3 px-4">
        <h6 class="mb-0 fw-bold" style="color: #1c3451;">Daftar Menu</h6>
        <a href="{{ route('admin.menus.create') }}" class="btn btn-sm btn-admin-primary">
            <i class="fas fa-plus me-1"></i> Tambah Menu
        </a>
    </div>
    <div class="card-body px-4">
        <!-- Filter -->
        <div class="row mb-3">
            <div class="col-md-6">
                <form method="GET" class="d-flex gap-2">
                    <select name="category" class="form-select w-auto" onchange="this.form.submit()">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>
                                {{ ucfirst($cat) }}
                            </option>
                        @endforeach
                    </select>
                    <input type="text" name="search" class="form-control" placeholder="Cari menu..." 
                           value="{{ request('search') }}" onchange="this.form.submit()">
                </form>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Gambar</th>
                        <th>Nama</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Status</th>
                        <th>Rekomendasi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($menus as $menu)
                    <tr>
                        <td>
                            @if($menu->image && Storage::disk('public')->exists($menu->image))
                                <img src="{{ asset('storage/' . $menu->image) }}" 
                                     width="52" height="52"
                                     style="object-fit: cover; border-radius: 10px; border: 2px solid #e8e0d0;"
                                     onerror="this.onerror=null; this.src='https://placehold.co/52x52/e8e0d0/c1a067?text=No+Image';">
                            @else
                                <div class="d-flex align-items-center justify-content-center"
                                     style="width: 52px; height: 52px; border-radius: 10px; background: #f0ebe0;">
                                    <i class="fas fa-utensils" style="color: #c1a067;"></i>
                                </div>
                            @endif
                        </td>
                        <td class="fw-bold" style="color: #1c3451;">{{ $menu->name }}</td>
                        <td>
                            <span class="badge-category">{{ ucfirst($menu->category) }}</span>
                        </td>
                        <td class="fw-semibold" style="color: #c1a067;">
                            Rp {{ number_format($menu->price, 0, ',', '.') }}
                        </td>
                        <td>{!! $menu->status_label !!}</td>
                        <td>
                            @if($menu->is_recommended)
                                <span class="badge" style="background: #f0fdf4; color: #15803d; border: 1px solid #bbf7d0; border-radius: 20px; padding: 4px 10px; font-size: 11px;">Ya</span>
                            @else
                                <span class="badge" style="background: #f9fafb; color: #6b7280; border: 1px solid #e5e7eb; border-radius: 20px; padding: 4px 10px; font-size: 11px;">Tidak</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('admin.menus.show', $menu) }}" class="btn btn-action btn-action-view" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.menus.edit', $menu) }}" class="btn btn-action btn-action-edit" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.menus.destroy', $menu) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-action btn-action-delete" title="Hapus"
                                            onclick="return confirm('Yakin hapus menu ini?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                                <button onclick="toggleAvailability({{ $menu->id }})"
                                        class="btn btn-action {{ $menu->is_available ? 'btn-action-warning' : 'btn-action-success' }}"
                                        title="{{ $menu->is_available ? 'Nonaktifkan' : 'Aktifkan' }}">
                                    <i class="fas {{ $menu->is_available ? 'fa-times' : 'fa-check' }}"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5">
                            <i class="fas fa-utensils fa-3x mb-3 d-block" style="color: #c1a067; opacity: 0.4;"></i>
                            <span class="text-muted">Belum ada data menu</span>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            {{ $menus->links() }}
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .btn-admin-primary {
        background: #1c3451;
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
        padding: 7px 16px;
        transition: all 0.2s;
    }

    .btn-admin-primary:hover {
        background: #c1a067;
        color: white;
    }

    .badge-category {
        background: #eef2ff;
        color: #1c3451;
        border-radius: 20px;
        padding: 4px 12px;
        font-size: 12px;
        font-weight: 500;
    }

    .table thead th {
        background: #f8f9fa;
        color: #1c3451;
        font-weight: 600;
        font-size: 12px;
        letter-spacing: 0.4px;
        border-bottom: 2px solid #f0ebe0;
        padding: 12px 16px;
    }

    .table tbody td {
        padding: 12px 16px;
        border-bottom: 1px solid #f5f5f5;
        font-size: 14px;
    }

    .table tbody tr:hover {
        background: #fdfcfa;
    }

    .btn-action {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        border: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        transition: all 0.2s;
        padding: 0;
    }

    .btn-action-view    { background: #eef2ff; color: #1c3451; }
    .btn-action-view:hover { background: #1c3451; color: white; }

    .btn-action-edit    { background: #fef9ec; color: #c1a067; }
    .btn-action-edit:hover { background: #c1a067; color: white; }

    .btn-action-delete  { background: #fef2f2; color: #dc2626; }
    .btn-action-delete:hover { background: #dc2626; color: white; }

    .btn-action-warning { background: #fff7ed; color: #ea580c; }
    .btn-action-warning:hover { background: #ea580c; color: white; }

    .btn-action-success { background: #f0fdf4; color: #15803d; }
    .btn-action-success:hover { background: #15803d; color: white; }
</style>
@endpush

@push('scripts')
<script>
    function toggleAvailability(id) {
        fetch(`/admin/menus/${id}/toggle-availability`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        }).then(response => response.json()).then(data => {
            if(data.success) location.reload();
        }).catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan, silakan refresh halaman dan coba lagi.');
        });
    }
</script>
@endpush