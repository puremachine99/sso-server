<x-app-layout>
    <x-style-authorize />

    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="w-full max-w-md bg-white rounded-2xl shadow-neumorph p-6">

            {{-- Header --}}
            <div class="text-center mb-8">
                <div class="mx-auto mb-4 w-20 h-20 rounded-2xl flex items-center justify-center bg-gradient-to-br from-blue-50 to-white shadow-neumorph">
                    <i class="fas fa-shield-alt text-blue-500 text-2xl"></i>
                </div>
                <h2 class="text-2xl font-semibold text-gray-800">Authorize {{ $client->name }}</h2>
                <p class="text-gray-500 mt-2 text-sm">{{ $client->name }} wants to access your account</p>
            </div>

            {{-- Permissions --}}
            <x-permission-list :scopes="$scopes" />

            {{-- Actions --}}
            @foreach ([
                ['method' => 'POST', 'variant' => 'primary', 'icon' => 'check-circle', 'label' => 'Authorize Access'],
                ['method' => 'DELETE', 'variant' => 'secondary', 'icon' => 'times-circle', 'label' => 'Deny Access'],
            ] as $action)
                <form method="post" action="/oauth/authorize" class="mb-4">
                    @csrf
                    @if ($action['method'] === 'DELETE') @method('DELETE') @endif

                    <input type="hidden" name="state" value="{{ request()->state }}">
                    <input type="hidden" name="client_id" value="{{ $client->id }}">
                    <input type="hidden" name="auth_token" value="{{ $authToken }}">

                    <x-button variant="{{ $action['variant'] }}">
                        <i class="fas fa-{{ $action['icon'] }} mr-2"></i> {{ $action['label'] }}
                    </x-button>
                </form>
            @endforeach

        </div>
    </div>
</x-app-layout>
