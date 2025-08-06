@props([
    'label' => '',
    'value' => '',
])

<div class="space-y-1">
    @if ($label)
        <label class="text-sm font-medium text-gray-500 dark:text-gray-400">
            {{ $label }}
        </label>
    @endif

    <div class="text-base text-gray-950 dark:text-white">
        {{ is_string($value) || is_numeric($value) ? $value : '' }}
    </div>
</div>
