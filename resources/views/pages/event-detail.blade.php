@extends('layouts.app')

@section('title', $event->title)

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm overflow-hidden">
                <img src="{{ asset('storage/' . $event->banner_image) }}" class="card-img-top" alt="{{ $event->title }}">
                <div class="card-body p-4">
                    <span class="badge bg-primary mb-3">Event</span>
                    <h1 class="display-5 fw-bold mb-3">{{ $event->title }}</h1>
                    <div class="mb-3 d-flex gap-3">
                        <small><i class="fas fa-calendar-alt me-1"></i> {{ \Carbon\Carbon::parse($event->start_date)->format('d F Y H:i') }}</small>
                        <small><i class="fas fa-map-marker-alt me-1"></i> {{ $event->location }}</small>
                    </div>
                    <p class="text-muted">{{ $event->description }}</p>
                    
                    @if($event->ticket_price)
                    <div class="alert alert-success">
                        <strong>Ticket Price:</strong> Rp {{ number_format($event->ticket_price, 0, ',', '.') }}
                    </div>
                    @endif
                    
                    <div class="alert alert-info">
                        <strong>Contact Person:</strong><br>
                        Phone: {{ json_decode($event->contact_info)->phone ?? '-' }}<br>
                        Email: {{ json_decode($event->contact_info)->email ?? '-' }}
                    </div>
                    
                    <a href="{{ route('branding.contact') }}" class="btn btn-primary">Contact Us</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection