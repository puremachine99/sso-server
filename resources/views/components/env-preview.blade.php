@php
    use App\Models\ClientSecret;

    $app_url = config('app.url');
    $redirect_uri = $client->redirect_uris[0] ?? 'http://localhost/callback';

    // 1. Ambil dari session (jika baru dibuat)
    $client_secret = session('new_client_secret');

    // 2. Kalau tidak ada, ambil dari table oauth_client_secrets
    if (!$client_secret) {
        $client_secret = optional(ClientSecret::find($client->id))->secret ?? 'SECRET_NOT_AVAILABLE';
    }

    $env = <<<ENV
    SMARTID_AUTH_URL=$app_url
    SMARTID_CLIENT_ID={$client->id}
    SMARTID_CLIENT_SECRET=$client_secret
    SMARTID_REDIRECT_URI=$redirect_uri
    ENV;
@endphp


<div x-data="{ copied: false }" class="space-y-4">
    <textarea id="env-content"
        class="w-full p-3 text-sm bg-gray-100 dark:bg-gray-800 text-gray-800 dark:text-gray-100 rounded" rows="6"
        readonly>{{ $env }}</textarea>

    <x-filament::button color="gray"
        x-on:click="
            navigator.clipboard.writeText($refs.envContent.value).then(() => copied = true);
            setTimeout(() => copied = false, 2000);
        ">
        <span x-show="!copied">Salin ke Clipboard</span>
        <span x-show="copied">Disalin!</span>
    </x-filament::button>
</div>

<script>
    // Alpine refs need to be after DOM mount if you're using this outside Livewire
    document.addEventListener('alpine:init', () => {
        Alpine.data('envCopy', () => ({
            copied: false
        }))
    })
</script>
