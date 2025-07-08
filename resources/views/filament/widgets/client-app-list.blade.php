<x-filament::widget>
    <x-filament::card>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @foreach ($this->getApps() as $app)
                @php
                    $uris = is_array($app->redirect_uris)
                        ? $app->redirect_uris
                        : json_decode($app->redirect_uris, true);
                    $fullUri = is_array($uris) ? $uris[0] ?? '#' : '#';

                    // Ambil hanya scheme + domain (tanpa path)
                    $uri = parse_url($fullUri, PHP_URL_SCHEME) . '://' . parse_url($fullUri, PHP_URL_HOST);
                @endphp

                <a href="{{ $uri }}" target="_blank"
                    class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-sm p-4 hover:bg-gray-50 dark:hover:bg-gray-700 transition-all duration-200">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $app->name }}</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 truncate">{{ $uri }}</p>
                </a>
            @endforeach

        </div>
    </x-filament::card>
</x-filament::widget>
