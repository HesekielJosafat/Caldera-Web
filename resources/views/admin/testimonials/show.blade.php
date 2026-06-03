@extends('layouts.admin')

@section('title', 'Detail Testimoni')

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

    .btn-back {
        background: rgba(255,255,255,0.15);
        color: #fff;
        border: 1px solid rgba(255,255,255,0.3);
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
        padding: 36px 40px;
    }

    /* Avatar */
    .testimonial-avatar {
        width: 72px;
        height: 72px;
        background: linear-gradient(135deg, #1c3451, #2a4a6b);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        font-weight: 700;
        color: #c1a067;
        margin: 0 auto 16px;
        letter-spacing: -1px;
    }

    .testimonial-name {
        font-size: 22px;
        font-weight: 700;
        color: #1c3451;
        margin-bottom: 4px;
    }

    .testimonial-email {
        font-size: 13px;
        color: #9ca3af;
        margin-bottom: 4px;
    }

    .testimonial-meta {
        font-size: 13px;
        color: #6b7280;
        margin-bottom: 0;
    }

    /* Stars */
    .star-rating i {
        font-size: 22px;
        margin: 0 2px;
    }

    /* Comment box */
    .comment-box {
        background: #f8fafc;
        border-left: 4px solid #c1a067;
        border-radius: 0 12px 12px 0;
        padding: 20px 24px;
        margin: 24px 0;
    }

    .comment-box p {
        font-size: 16px;
        font-style: italic;
        color: #374151;
        line-height: 1.7;
        margin: 0;
    }

    /* Info row */
    .info-row {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 10px 0;
        border-bottom: 1px solid #f0f0f0;
        font-size: 13px;
        color: #6b7280;
    }

    .info-row:last-child { border-bottom: none; }

    .info-row .info-label {
        font-weight: 600;
        color: #374151;
        min-width: 140px;
    }

    .info-row i {
        color: #c1a067;
        width: 16px;
        text-align: center;
    }

    /* Badges */
    .badge-approved {
        background: rgba(21,128,61,0.12);
        color: #15803d;
        font-size: 12px;
        font-weight: 600;
        padding: 5px 12px;
        border-radius: 8px;
    }

    .badge-pending {
        background: rgba(217,119,6,0.12);
        color: #d97706;
        font-size: 12px;
        font-weight: 600;
        padding: 5px 12px;
        border-radius: 8px;
    }

    .badge-featured {
        background: rgba(193,160,103,0.15);
        color: #a98750;
        font-size: 12px;
        font-weight: 600;
        padding: 5px 12px;
        border-radius: 8px;
    }

    .badge-service-restaurant { background: rgba(37,99,235,0.1); color: #2563eb; font-size: 12px; font-weight: 600; padding: 5px 12px; border-radius: 8px; }
    .badge-service-pool       { background: rgba(6,182,212,0.12); color: #0891b2; font-size: 12px; font-weight: 600; padding: 5px 12px; border-radius: 8px; }
    .badge-service-event      { background: rgba(21,128,61,0.12); color: #15803d; font-size: 12px; font-weight: 600; padding: 5px 12px; border-radius: 8px; }

    /* Approve button */
    .btn-approve {
        background: #15803d;
        color: #fff;
        border: none;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 600;
        padding: 10px 22px;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .btn-approve:hover {
        background: #166534;
        color: #fff;
        transform: translateY(-1px);
    }

    .divider {
        border: none;
        border-top: 1px solid #f0f0f0;
        margin: 24px 0;
    }
</style>
@endpush

@section('content')

<div class="report-page-header">
    <div class="d-flex align-items-center">
        <div class="header-icon">
            <i class="fas fa-comment-dots"></i>
        </div>
        <h6>Detail Testimoni</h6>
    </div>
    <a href="{{ route('admin.testimonials.index') }}" class="btn-back">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="card report-main-card">
    <div class="card-body">
        <div class="row justify-content-center">
            <div class="col-md-7">

                <!-- Customer Info -->
                <div class="text-center mb-2">
                    <div class="testimonial-avatar">
                        {{ strtoupper(substr($testimonial->customer_name, 0, 1)) }}
                    </div>
                    <div class="testimonial-name">{{ $testimonial->customer_name }}</div>
                    <div class="testimonial-email">{{ $testimonial->customer_email }}</div>
                </div>

                <!-- Star Rating -->
                <div class="text-center mb-2 star-rating">
                    @for($i = 1; $i <= 5; $i++)
                        @if($i <= $testimonial->rating)
                            <i class="fas fa-star text-warning"></i>
                        @else
                            <i class="far fa-star" style="color:#e5e7eb;"></i>
                        @endif
                    @endfor
                </div>

                <!-- Comment -->
                <div class="comment-box">
                    <p>"{{ $testimonial->comment }}"</p>
                </div>

                <hr class="divider">

                <!-- Detail Info -->
                <div class="info-row">
                    <i class="fas fa-concierge-bell"></i>
                    <span class="info-label">Layanan</span>
                    @if($testimonial->service_type == 'restaurant')
                        <span class="badge-service-restaurant">Restoran</span>
                    @elseif($testimonial->service_type == 'pool')
                        <span class="badge-service-pool">Kolam Renang</span>
                    @else
                        <span class="badge-service-event">Event</span>
                    @endif
                </div>

                @if($testimonial->visit_date)
                <div class="info-row">
                    <i class="fas fa-calendar-alt"></i>
                    <span class="info-label">Tanggal Kunjungan</span>
                    <span>{{ \Carbon\Carbon::parse($testimonial->visit_date)->format('d M Y') }}</span>
                </div>
                @endif

                <div class="info-row">
                    <i class="fas fa-shield-alt"></i>
                    <span class="info-label">Status</span>
                    <div class="d-flex gap-2">
                        @if($testimonial->is_approved)
                            <span class="badge-approved"><i class="fas fa-check me-1"></i>Disetujui</span>
                        @else
                            <span class="badge-pending"><i class="fas fa-clock me-1"></i>Pending</span>
                        @endif
                        @if($testimonial->is_featured)
                            <span class="badge-featured"><i class="fas fa-star me-1"></i>Featured</span>
                        @endif
                    </div>
                </div>

                <!-- Approve Action -->
                @if(!$testimonial->is_approved)
                <hr class="divider">
                <div class="text-end">
                    <form action="{{ route('admin.testimonials.approve', $testimonial->id) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn-approve">
                            <i class="fas fa-check"></i> Setujui Testimoni
                        </button>
                    </form>
                </div>
                @endif

            </div>
        </div>
    </div>
</div>

@endsection