<x-filament-widgets::widget>
    <x-filament::section>
        <div class="flex items-center gap-x-3">
            <img class="fi-avatar object-cover object-center fi-circular rounded-full h-10 w-10 fi-user-avatar"
                src="{{ $this->getUser()->getFilamentAvatarUrl() ?? 'https://ui-avatars.com/api/?name=' . urlencode($this->getUser()->name) }}"
                alt="Avatar of {{ $this->getUser()->name }}">

            <div class="flex-1">
                <h2 class="text-base font-semibold leading-6 text-gray-950 dark:text-white">
                    {{ $this->getUser()->name }}
                </h2>
                <p class="text-sm mt-1 text-gray-500 dark:text-gray-400">
                    {{-- Badges jabatan di sini --}}
                    @foreach ($this->jobBadges() as $badge)
                        <x-filament::badge :color="$badge['color']" size="xs" class="ms-2">
                            {{ $badge['label'] }}
                        </x-filament::badge>
                    @endforeach
                </p>
            </div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
