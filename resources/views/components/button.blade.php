@props([
    'variant' => 'primary', // primary | secondary
    'type' => 'submit'
])

@php
$base = 'w-full py-2.5 px-4 rounded-xl font-medium transition-all duration-300 ease-in-out';
$styles = match($variant) {
    'primary' => 'btn-primary',
    'secondary' => 'btn-secondary',
    default => 'btn-primary',
};
@endphp

<button type="{{ $type }}" {{ $attributes->merge(['class' => "$base $styles"]) }}>
    {{ $slot }}
</button>
