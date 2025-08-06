<div class="flex flex-col space-y-1">
    <label class="text-sm text-gray-500">{{ $label }}</label>
    <div class="text-base text-gray-900 font-medium">
        {{ data_get($getState(), $field->getName()) ?? '—' }}
    </div>
</div>
