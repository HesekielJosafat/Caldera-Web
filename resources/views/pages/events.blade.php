@extends('layouts.app')

@section('title', 'Events')

@section('content')
<div class="container py-5">
    <div class="text-center mb-5">
        <h1 class="display-4 fw-bold mb-3">Upcoming Events</h1>
        <p class="lead text-muted">Join our special events and celebrations</p>
    </div>

    <div class="row g-4">
        @forelse($events as $event)
        <div class="col-md-6 col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <img src="{{ asset('storage/' . $event->banner_image) }}" class="card-img-top" alt="{{ $event->title }}" style="height: 200px; object-fit: cover;">
                <div class="card-body">
                    <span class="badge bg-primary mb-2">Event</span>
                    <h5 class="fw-bold">{{ $event->title }}</h5>
                    <p class="text-muted small">{{ Str::limit($event->description, 100) }}</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <small><i class="fas fa-calendar-alt me-1"></i> {{ \Carbon\Carbon::parse($event->start_date)->format('d M Y') }}</small>
                        <small><i class="fas fa-map-marker-alt me-1"></i> {{ $event->location }}</small>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0 pb-3">
                    <a href="{{ route('branding.events.detail', $event->slug) }}" class="btn btn-outline-primary w-100">View Details</a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <i class="fas fa-calendar-alt fa-4x text-muted mb-3"></i>
            <p class="text-muted">Belum ada event</p>
        </div>
        @endforelse
    </div>

    {{ $events->links() }}
</div>
@endsection