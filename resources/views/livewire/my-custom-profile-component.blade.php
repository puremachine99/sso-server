<x-filament::page>
    <x-filament::section>
        <x-filament::section.header title="Informasi Pengguna" />

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
            <div>
                <x-filament::label value="Nama" />
                <x-filament::input
                    value="{{ auth()->user()?->name }}"
                    disabled
                    readonly
                />
            </div>
            <div>
                <x-filament::label value="Email" />
                <x-filament::input
                    value="{{ auth()->user()?->email }}"
                    disabled
                    readonly
                />
            </div>
        </div>
    </x-filament::section>
</x-filament::page>
