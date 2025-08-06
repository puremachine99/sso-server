<x-filament::section>
    <x-slot name="header">
        <h2 class="text-xl font-bold tracking-tight">
            Profile Information
        </h2>

        <p class="text-sm text-gray-500 dark:text-gray-400">
            This section displays your account name and email.
        </p>
    </x-slot>

    <x-filament::grid>
        <x-filament::card>
            <dl class="text-sm text-gray-200">
                <div class="mb-2">
                    <dt class="font-medium text-white">Name</dt>
                    <dd>{{ auth()->user()->name }}</dd>
                </div>
                <div>
                    <dt class="font-medium text-white">Email</dt>
                    <dd>{{ auth()->user()->email }}</dd>
                </div>
            </dl>
        </x-filament::card>
    </x-filament::grid>
</x-filament::section>
