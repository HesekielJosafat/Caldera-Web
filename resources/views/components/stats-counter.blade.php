@props(['id', 'value', 'label', 'icon', 'color', 'delay' => 0])

<div class="col-lg-3 col-md-6 mb-4 fade-in-up" style="animation-delay: {{ $delay }}s">
    <div class="stats-number" id="{{ $id }}">0</div>
    <p class="fw-bold mt-2">{{ $label }}</p>
    <i class="fas {{ $icon }} text-{{ $color }}" style="font-size: 2rem;"></i>
</div>

@push('scripts')
<script>
    // Counter akan diinisialisasi dari home.blade.php
</script>
@endpush