<x-app-layout>
    <div class="min-h-screen flex items-center justify-center p-4 login-container">
        <div class="w-full max-w-md p-8 login-card text-center">
            <div
                class="mx-auto mb-4 w-20 h-20 rounded-2xl flex items-center justify-center bg-gradient-to-br from-blue-50 to-white shadow-neumorph">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-red-500" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 9v2m0 4h.01M5.07 19h13.86A2 2 0 0021 17.15L13.93 4.85a2 2 0 00-3.86 0L3 17.15A2 2 0 005.07 19z"/>
                </svg>
            </div>

            <h1 class="text-2xl font-semibold text-gray-800 mb-2">Halaman ini tampaknya tidak ada.</h1>
            <p class="text-gray-500 mb-6 text-sm">
                Tautan reset password tidak valid, telah kedaluwarsa, atau sudah digunakan.
            </p>

            <a href="{{ route('login') }}"
               class="w-full btn-primary py-2.5 px-4 rounded-xl inline-flex items-center justify-center">
                Kembali Ke Halaman Login
            </a>
        </div>
    </div>
</x-app-layout>
