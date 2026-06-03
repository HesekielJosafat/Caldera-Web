{{-- resources/views/customer/notifications.blade.php --}}
@extends('layouts.app')

@section('title', 'Notifikasi - Caldera')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent">
                    <h4 class="mb-0 fw-bold" style="color: #1c3451;">
                        <i class="fas fa-bell me-2" style="color: #c1a067;"></i> Notifikasi Saya
                    </h4>
                </div>
                <div class="card-body p-0">
                    @forelse($notifications as $notif)
                    <div class="notification-item p-3 border-bottom {{ $notif->read_at ? '' : 'bg-light' }}" 
                         data-id="{{ $notif->id }}"
                         style="transition: all 0.2s;">
                        <div class="d-flex">
                            <div class="me-3">
                                <div class="notification-icon rounded-circle d-flex align-items-center justify-content-center" 
                                     style="width: 45px; height: 45px; background: {{ $notif->color == 'success' ? '#e8f5e9' : '#f0ebe0' }};">
                                    <i class="fas {{ $notif->icon }} fa-lg" style="color: {{ $notif->color == 'success' ? '#2e7d32' : '#c1a067' }};"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between align-items-start">
                                    <h6 class="fw-bold mb-1" style="color: #1c3451;">
                                        {{ $notif->title }}
                                        @if(!$notif->read_at)
                                            <span class="badge bg-danger ms-2" style="font-size: 9px;">NEW</span>
                                        @endif
                                    </h6>
                                    <small class="text-muted">{{ $notif->created_at->diffForHumans() }}</small>
                                </div>
                                <p class="text-muted small mb-2">{{ $notif->body }}</p>
                                @if($notif->booking_code)
                                <div class="mt-2">
                                    <a href="{{ $notif->url ?? '#' }}" class="btn btn-sm btn-outline-caldera">
                                        <i class="fas fa-eye me-1"></i> Lihat Detail
                                    </a>
                                    @if(!$notif->read_at)
                                    <form action="{{ route('notifications.mark-read', $notif->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-link text-muted">
                                            <i class="fas fa-check-circle"></i> Tandai Dibaca
                                        </button>
                                    </form>
                                    @endif
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-5">
                        <i class="fas fa-bell-slash fa-4x mb-3" style="color: #c1a067; opacity: 0.4;"></i>
                        <p class="text-muted">Belum ada notifikasi</p>
                    </div>
                    @endforelse
                </div>
                @if($notifications->hasPages())
                <div class="card-footer bg-transparent">
                    {{ $notifications->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
.btn-outline-caldera {
    border: 1px solid #c1a067;
    color: #c1a067;
    background: transparent;
    border-radius: 8px;
    font-size: 12px;
    padding: 4px 12px;
    transition: all 0.2s;
}
.btn-outline-caldera:hover {
    background: #c1a067;
    color: white;
}
.notification-item:hover {
    background: #f8f6f2;
}
body.dark-mode .notification-item:hover {
    background: #2d2d3a;
}
body.dark-mode .notification-item.bg-light {
    background: #2a2a3a !important;
}
</style>
@endsection