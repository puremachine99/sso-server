<x-filament::section>
    <x-filament::section.header title="Informasi Pengguna" />
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
        <div>
            <x-filament::label for="name" value="Nama" />
            <x-filament::input
                id="name"
                type="text"
                value="{{ $user->name }}"
                disabled
                readonly
            />
        </div>

        <div>
            <x-filament::label for="email" value="Email" />
            <x-filament::input
                id="email"
                type="text"
                value="{{ $user->email }}"
                disabled
                readonly
            />
        </div>
    </div>
</x-filament::section>
