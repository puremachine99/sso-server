<x-filament::widget>
    <x-filament::card>
        <div class="px-4 py-2">
            <h2 class="text-xl font-bold text-gray-800 dark:text-gray-200">
                Connected Applications
            </h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">
                These applications are authorized to access your portal data
            </p>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
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
                    <a href="{{ $uri }}" target="_blank" class="">
                        <div
                            class="group relative p-4 bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 hover:shadow-md transition-all duration-200 overflow-hidden">
                            <div
                                class="absolute inset-0 bg-primary-500/5 group-hover:bg-primary-500/10 transition-colors duration-300">
                            </div>

                            <div class="p-5 flex flex-col items-center relative z-10">
                                <!-- App Icon with gradient border -->
                                <div class="mb-4 p-1 rounded-full bg-gradient-to-tr from-primary-400 to-primary-600">
                                    @if ($iconUrl)
                                        <img src="{{ imgproxy($iconUrl) }}"alt="{{ $app->name }} icon"
                                            class="w-16 h-16 object-cover rounded-full border-1 border-white dark:border-gray-800 shadow-sm">
                                    @else
                                        <div
                                            class="w-16 h-16 rounded-full bg-gray-100 dark:bg-gray-700 border-1 border-white dark:border-gray-800 flex items-center justify-center text-primary-500">
                                            <x-heroicon-o-cube class="w-6 h-6" />
                                        </div>
                                    @endif
                                </div>

                                <!-- App Details -->
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white text-center mb-1">
                                    {{ $app->name }}
                                </h3>

                                <p class="text-xs text-gray-500 dark:text-gray-400 text-center mb-3 truncate w-full">
                                    {{ $uri }}
                                </p>

                                <!-- Action Button -->

                            </div>

                            <!-- Hover effect indicator -->
                            <div
                                class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-primary-400 to-primary-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            @if (count($this->getApps()) === 0)
                <div class="text-center py-12">
                    <div class="mx-auto h-24 w-24 text-gray-400 dark:text-gray-500">
                        <x-heroicon-o-link class="w-full h-full" />
                    </div>
                    <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-white">
                        No connected applications
                    </h3>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        You haven't connected any applications to your account yet.
                    </p>
                </div>
            @endif
        </div>
    </x-filament::card>
</x-filament::widget>
