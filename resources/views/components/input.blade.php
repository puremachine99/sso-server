@props(['name', 'type' => 'text', 'label' => null, 'placeholder' => '', 'icon' => null, 'required' => false])

<div class="space-y-1">
    @if ($label)
        <label for="{{ $name }}" class="block text-sm font-medium text-gray-700">
            {{ $label }}
        </label>
    @endif
    <div class="relative">
        @if ($icon)
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="{{ $icon }} text-gray-400"></i>
            </div>
        @endif
        <input 
            id="{{ $name }}"
            type="{{ $type }}"
            name="{{ $name }}"
            value="{{ old($name) }}"
            @if($required) required @endif
            placeholder="{{ $placeholder }}"
            class="input-field {{ $icon ? 'pl-10' : 'pl-4' }} w-full px-4 py-3 rounded-lg focus:ring-0 transition-all"
        >
    </div>
</div>
