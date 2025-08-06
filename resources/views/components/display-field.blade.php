@props([
    'label' => '',
    'value' => '',
])

<div class="fi-fo-field-wrp space-y-1">
    @if ($label)
        <label class="fi-fo-field-wrp-label inline-flex items-center gap-x-3">
            <span class="text-sm font-medium leading-6 text-gray-950 dark:text-white">
                {{ $label }}
            </span>
        </label>
    @endif

    <div class="text-base text-gray-950 dark:text-white fi-input-wrp">
        {{ is_scalar($value) ? $value : '' }}
    </div>
</div>
