<x-filament::widget>
    <x-filament::card>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @foreach ($this->getApps() as $app)
                @php
                    $uris = is_array($app->redirect_uris)
                        ? $app->redirect_uris
                        : json_decode($app->redirect_uris, true);
                    $fullUri = is_array($uris) ? $uris[0] ?? '#' : '#';
                    $uri = parse_url($fullUri, PHP_URL_SCHEME) . '://' . parse_url($fullUri, PHP_URL_HOST);

                    $secret = \App\Models\ClientSecret::find($app->id);
                    $iconUrl = $secret?->icon_path ? asset('storage/' . $secret->icon_path) : null;
                @endphp

                <a href="{{ $uri }}" target="_blank"
                    class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-sm p-4 hover:bg-gray-50 dark:hover:bg-gray-700 transition-all duration-200 flex flex-col items-center text-center">
                    
                    @if ($iconUrl)
                        <img src="{{ $iconUrl }}" alt="{{ $app->name }} icon"
                             class="w-32 h-32 object-cover rounded-full mb-2 shadow-sm">
                    @else
                        <div class="w-32 h-32 bg-gray-200 dark:bg-gray-700 rounded-full mb-2 flex items-center justify-center text-gray-400">
                            <x-heroicon-o-photo class="w-6 h-6" />
                        </div>
                    @endif

                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $app->name }}</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 truncate">{{ $uri }}</p>
                </a>
            @endforeach
        </div>
    </x-filament::card>
</x-filament::widget>
