@props(['type' => 'success', 'icon' => null])

@php
    $base = 'mt-4 p-3 rounded-lg flex items-start';
    $color = match($type) {
        'success' => 'alert-success text-green-600',
        'error' => 'alert-error text-red-600',
        default => 'alert-success text-green-600',
    };
@endphp

<div class="{{ $base }} {{ $color }}">
    @if ($icon)
        <i class="{{ $icon }} mt-1 mr-2"></i>
    @endif
    <span>{{ $slot }}</span>
</div>
