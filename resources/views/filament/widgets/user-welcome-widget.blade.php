<x-filament-widgets::widget>
    <x-filament::section>
        <div class="flex items-center gap-x-3">
            <img class="fi-avatar object-cover object-center fi-circular rounded-full h-10 w-10 fi-user-avatar"
                src="{{ $this->getUser()->getFilamentAvatarUrl() ?? 'https://ui-avatars.com/api/?name=' . urlencode($this->getUser()->name) }}"
                alt="Avatar of {{ $this->getUser()->name }}">

            <div class="flex-1">
                <h2 class="text-base font-semibold leading-6 text-gray-950 dark:text-white">
                    Welcome
                </h2>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    {{ $this->getUser()->name }}
                </p>
            </div>

            <form action="{{ route('filament.admin.auth.logout') }}" method="POST" class="my-auto">
                @csrf
                <button class="fi-icon-btn h-9 w-9 rounded-lg text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200"
                        title="Sign out" type="submit">
                    <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                              d="M3 4.25A2.25 2.25 0 0 1 5.25 2h5.5A2.25 2.25 0 0 1 13 4.25v2a.75.75 0 0 1-1.5 0v-2a.75.75 0 0 0-.75-.75h-5.5a.75.75 0 0 0-.75.75v11.5c0 .414.336.75.75.75h5.5a.75.75 0 0 0 .75-.75v-2a.75.75 0 0 1 1.5 0v2A2.25 2.25 0 0 1 10.75 18h-5.5A2.25 2.25 0 0 1 3 15.75V4.25Z"
                              clip-rule="evenodd"/>
                        <path fill-rule="evenodd"
                              d="M19 10a.75.75 0 0 0-.75-.75H8.704l1.048-.943a.75.75 0 1 0-1.004-1.114l-2.5 2.25a.75.75 0 0 0 0 1.114l2.5 2.25a.75.75 0 1 0 1.004-1.114l-1.048-.943h9.546A.75.75 0 0 0 19 10Z"
                              clip-rule="evenodd"/>
                    </svg>
                </button>
            </form>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
<x-filament-widgets::widget>
    <x-filament::section>
        <div class="flex items-center gap-x-3">
            <img class="fi-avatar object-cover object-center fi-circular rounded-full h-10 w-10 fi-user-avatar"
                src="{{ $this->getUser()->getFilamentAvatarUrl() ?? 'https://ui-avatars.com/api/?name=' . urlencode($this->getUser()->name) }}"
                alt="Avatar of {{ $this->getUser()->name }}">

            <div class="flex-1">
                <h2 class="text-base font-semibold leading-6 text-gray-950 dark:text-white">
                    Welcome
                </h2>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    {{ $this->getUser()->name }}
                </p>
            </div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
