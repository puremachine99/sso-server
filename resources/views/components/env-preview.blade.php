@php
    $clientSecret = \App\Models\ClientSecret::find($client->id);
@endphp
<style>
    .fi-notification .fi-icon-button {
        display: none !important;
    }
</style>

@if ($clientSecret)
    <div x-data="{
        copySuccess: false,
        async copyToClipboard() {
            try {
                const content = this.$refs.textarea.value;
                await navigator.clipboard.writeText(content);
                this.copySuccess = true;
    
                // Trigger notifikasi Filament
                window.dispatchEvent(new CustomEvent('notify', {
                    detail: {
                        type: 'success',
                        title: 'Disalin ke Clipboard',
                        message: 'Konfigurasi SMARTID berhasil disalin.',
                    }
                }));
    
                setTimeout(() => this.copySuccess = false, 2000);
            } catch (e) {
                // Error notification
                window.dispatchEvent(new CustomEvent('notify', {
                    detail: {
                        type: 'danger',
                        title: 'Gagal Menyalin',
                        message: e.message || 'Clipboard gagal.',
                    }
                }));
            }
        }
    }" class="space-y-2">


        <textarea x-ref="textarea" readonly rows="6"
            class="w-full h-40 text-sm font-mono whitespace-pre-wrap p-2 border rounded bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-700">SMARTID_AUTH_URL={{ config('app.url') }}
SMARTID_CLIENT_ID={{ $clientSecret->client_id }}
SMARTID_CLIENT_SECRET={{ $clientSecret->secret }}
SMARTID_REDIRECT_URI={{ $client->redirect_uris[0] ?? config('app.url') . '/callback' }}</textarea>

        <div class="flex items-center gap-2">
            <x-filament::button x-on:click="copyToClipboard" icon="heroicon-o-clipboard" color="primary" class="shrink-0">
                Copy to Clipboard
            </x-filament::button>

            <span x-show="copySuccess" x-transition class="text-sm text-success-600 dark:text-success-400">
                Copied!
            </span>
        </div>
    </div>
@else
    <div class="text-danger-600 dark:text-danger-400">
        Client secret tidak ditemukan.
    </div>
@endif
