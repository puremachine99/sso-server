<x-filament::section>
    <x-slot name="header">
        <h2 class="text-lg font-bold">Profil Saya</h2>
    </x-slot>

    <x-filament::card>
        <p><strong>Nama:</strong> {{ auth()->user()->name }}</p>
        <p><strong>Email:</strong> {{ auth()->user()->email }}</p>
    </x-filament::card>
</x-filament::section>
