<x-app-layout>
    <x-style-authorize />

    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="w-full max-w-md bg-white rounded-2xl shadow-neumorph p-8 space-y-6">

            {{-- Header --}}
            <x-auth-header 
                icon="fas fa-key" 
                title="Lupa Password" 
                subtitle="Masukkan email untuk reset password"
            />

            {{-- Form --}}
            <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
                @csrf
                <x-input name="email" type="email" label="Email" placeholder="email@example.com" icon="fas fa-envelope" required />
                <x-button variant="primary"><i class="fas fa-paper-plane mr-2"></i> Kirim Link Reset</x-button>
            </form>

            {{-- Alerts --}}
            @if (session('status'))
                <x-alert type="success" icon="fas fa-check-circle">{{ session('status') }}</x-alert>
            @endif
            @error('email')
                <x-alert type="error" icon="fas fa-exclamation-circle">{{ $message }}</x-alert>
            @enderror

            {{-- Back --}}
            <x-auth-footer link="{{ route('login') }}" text="Kembali ke Login" />
        </div>
    </div>
</x-app-layout>
