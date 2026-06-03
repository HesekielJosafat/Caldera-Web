@extends('layouts.admin')

@section('title', 'Testimonials')

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

    .btn-export:hover {
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

    /* Filter bar */
    .filter-bar {
        background: #f8fafc;
        border-radius: 12px;
        padding: 14px 18px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
    }

    .filter-bar .form-select,
    .filter-bar .form-control {
        font-size: 13px;
        border-radius: 8px;
        border: 1px solid #e5e7eb;
        color: #374151;
    }

    .filter-bar .form-select:focus,
    .filter-bar .form-control:focus {
        border-color: #c1a067;
        box-shadow: 0 0 0 3px rgba(193,160,103,0.15);
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

    /* Badges */
    .badge-approved {
        background: rgba(21,128,61,0.12);
        color: #15803d;
        font-size: 11px;
        font-weight: 600;
        padding: 4px 10px;
        border-radius: 6px;
    }

    .badge-pending {
        background: rgba(217,119,6,0.12);
        color: #d97706;
        font-size: 11px;
        font-weight: 600;
        padding: 4px 10px;
        border-radius: 6px;
    }

    .badge-featured {
        background: rgba(193,160,103,0.15);
        color: #a98750;
        font-size: 11px;
        font-weight: 600;
        padding: 4px 10px;
        border-radius: 6px;
        margin-left: 4px;
    }

    .badge-service-restaurant { background: rgba(37,99,235,0.1); color: #2563eb; font-size: 11px; font-weight: 600; padding: 4px 10px; border-radius: 6px; }
    .badge-service-pool       { background: rgba(6,182,212,0.12); color: #0891b2; font-size: 11px; font-weight: 600; padding: 4px 10px; border-radius: 6px; }
    .badge-service-event      { background: rgba(21,128,61,0.12); color: #15803d; font-size: 11px; font-weight: 600; padding: 4px 10px; border-radius: 6px; }

    /* Action buttons */
    .btn-action-view {
        background: #1c3451;
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: 5px 10px;
        font-size: 12px;
        transition: all 0.2s;
    }

    .btn-action-view:hover { background: #c1a067; color: #fff; }

    .btn-action-approve {
        background: #15803d;
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: 5px 10px;
        font-size: 12px;
        transition: all 0.2s;
    }

    .btn-action-approve:hover { background: #166534; color: #fff; }

    .btn-action-star {
        background: #d97706;
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: 5px 10px;
        font-size: 12px;
        transition: all 0.2s;
    }

    .btn-action-star:hover { opacity: 0.85; }

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

    .customer-name {
        font-weight: 700;
        color: #1c3451;
        font-size: 13px;
    }

    .customer-email {
        font-size: 11px;
        color: #9ca3af;
    }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #9ca3af;
    }

    .empty-state i { color: #dde2e8; margin-bottom: 16px; display: block; }
    .empty-state p { font-size: 14px; }
</style>
@endpush

@section('content')

<div class="report-page-header">
    <div class="d-flex align-items-center">
        <div class="header-icon">
            <i class="fas fa-comments"></i>
        </div>
        <h6>Daftar Testimoni</h6>
    </div>
    <a href="{{ route('admin.testimonials.export') }}" class="btn-export">
        <i class="fas fa-download"></i> Export
    </a>
</div>

<div class="card report-main-card">
    <div class="card-body">

        <!-- Filter Bar -->
        <div class="filter-bar">
            <select class="form-select form-select-sm" id="approveFilter" onchange="filterTestimonials()" style="width:140px;">
                <option value="">Semua Status</option>
                <option value="1">Disetujui</option>
                <option value="0">Pending</option>
            </select>
            <select class="form-select form-select-sm" id="ratingFilter" onchange="filterTestimonials()" style="width:140px;">
                <option value="">Semua Rating</option>
                <option value="5">5 Bintang</option>
                <option value="4">4 Bintang</option>
                <option value="3">3 Bintang</option>
                <option value="2">2 Bintang</option>
                <option value="1">1 Bintang</option>
            </select>
            <input type="text" class="form-control form-control-sm" id="searchFilter"
                   placeholder="Cari nama atau komentar..."
                   onkeyup="filterTestimonials()"
                   style="max-width:260px;">
        </div>

        <div class="table-responsive">
            <table class="table table-hover mb-0" id="testimonialsTable">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Rating</th>
                        <th>Komentar</th>
                        <th>Layanan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($testimonials as $testimonial)
                    <tr>
                        <td>
                            <div class="customer-name">{{ $testimonial->customer_name }}</div>
                            <div class="customer-email">{{ $testimonial->customer_email }}</div>
                        </td>
                        <td>
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $testimonial->rating)
                                    <i class="fas fa-star text-warning" style="font-size:12px;"></i>
                                @else
                                    <i class="far fa-star" style="font-size:12px; color:#e5e7eb;"></i>
                                @endif
                            @endfor
                        </td>
                        <td style="max-width:220px; color:#6b7280;">
                            {{ \Str::limit($testimonial->comment, 100) }}
                        </td>
                        <td>
                            @if($testimonial->service_type == 'restaurant')
                                <span class="badge-service-restaurant">Restoran</span>
                            @elseif($testimonial->service_type == 'pool')
                                <span class="badge-service-pool">Kolam</span>
                            @else
                                <span class="badge-service-event">Event</span>
                            @endif
                        </td>
                        <td>
                            @if($testimonial->is_approved)
                                <span class="badge-approved">Disetujui</span>
                            @else
                                <span class="badge-pending">Pending</span>
                            @endif
                            @if($testimonial->is_featured)
                                <span class="badge-featured"><i class="fas fa-star me-1" style="font-size:9px;"></i>Featured</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex gap-1 flex-wrap">
                                <a href="{{ route('admin.testimonials.show', $testimonial->id) }}"
                                   class="btn btn-action-view" title="Lihat Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @if(!$testimonial->is_approved)
                                    <form action="{{ route('admin.testimonials.approve', $testimonial->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-action-approve" title="Setujui">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>
                                @endif
                                <button onclick="toggleFeatured({{ $testimonial->id }})"
                                        class="btn btn-action-star" title="Toggle Featured">
                                    <i class="fas fa-star"></i>
                                </button>
                                <form action="{{ route('admin.testimonials.destroy', $testimonial->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-action-delete" title="Hapus"
                                            onclick="return confirm('Yakin hapus testimoni ini?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6">
                            <div class="empty-state">
                                <i class="fas fa-comments fa-4x"></i>
                                <p>Belum ada data testimoni</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $testimonials->links() }}
        </div>
    </div>
</div>

@push('scripts')
<script>
    function toggleFeatured(id) {
        fetch(`/admin/testimonials/${id}/toggle-featured`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        }).then(response => response.json()).then(data => {
            if(data.success) location.reload();
        });
    }

    function filterTestimonials() {
        const approved = document.getElementById('approveFilter').value;
        const rating = document.getElementById('ratingFilter').value;
        const search = document.getElementById('searchFilter').value.toLowerCase();

        const rows = document.querySelectorAll('#testimonialsTable tbody tr');

        rows.forEach(row => {
            let show = true;

            if (approved !== '') {
                const statusCell = row.cells[4]?.innerText.toLowerCase();
                const isApproved = approved === '1' ? 'disetujui' : 'pending';
                if (!statusCell || !statusCell.includes(isApproved)) show = false;
            }

            if (rating && show) {
                const ratingStars = row.cells[1]?.innerHTML;
                const starCount = (ratingStars.match(/fa-star/g) || []).length;
                if (starCount != rating) show = false;
            }

            if (search && show) {
                const text = row.innerText.toLowerCase();
                if (!text.includes(search)) show = false;
            }

            row.style.display = show ? '' : 'none';
        });
    }
</script>
@endpush

@endsection