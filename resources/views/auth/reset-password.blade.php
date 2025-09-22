<x-app-layout>
    @push('styles')
        <style>
            .login-container {
                background-color: #f0f2f5;
                background-image:
                    url('{{ imgproxy('images/bg.png') }}');
            }

            .login-card {
                background: #f0f2f5;

                border-radius: 24px;
                box-shadow:
                    4px 4px 8px rgba(163, 177, 198, 0.6),
                    -4px -4px 8px rgba(255, 255, 255, 0.7);
                border: 1px solid rgba(255, 255, 255, 0.2);
            }

            .btn-primary {
                background: linear-gradient(135deg, #4a6bff 0%, #2541b2 100%);
                box-shadow:
                    4px 4px 8px rgba(37, 65, 178, 0.2),
                    -2px -2px 4px rgba(255, 255, 255, 0.4);
                border: none;
                color: white;
                font-weight: 500;
                letter-spacing: 0.5px;
                transition: all 0.3s ease;
            }

            .btn-primary:hover {
                background: linear-gradient(135deg, #3d5af1 0%, #1a2f8f 100%);
                transform: translateY(-2px);
                box-shadow:
                    6px 6px 12px rgba(37, 65, 178, 0.3),
                    -3px -3px 6px rgba(255, 255, 255, 0.5);
            }

            .input-focus {
                background: #f0f2f5;
                border: 1px solid rgba(0, 0, 0, 0.05);
                box-shadow:
                    inset 3px 3px 6px rgba(163, 177, 198, 0.3),
                    inset -3px -3px 6px rgba(255, 255, 255, 0.8);
                transition: all 0.3s ease;
            }

            .input-focus:focus {
                border-color: rgba(74, 107, 255, 0.4);
                box-shadow:
                    inset 3px 3px 6px rgba(163, 177, 198, 0.3),
                    inset -3px -3px 6px rgba(255, 255, 255, 0.8),
                    0 0 0 3px rgba(74, 107, 255, 0.1);
            }

            .checkbox:focus {
                box-shadow: 0 0 0 3px rgba(74, 107, 255, 0.2);
            }

            .forgot-link {
                color: #4a6bff;
                transition: all 0.2s ease;
            }

            .forgot-link:hover {
                color: #2541b2;
                text-shadow: 0 0 4px rgba(37, 65, 178, 0.1);
            }

            .error-alert {
                background: #fef2f2;
                box-shadow:
                    4px 4px 8px rgba(239, 68, 68, 0.1),
                    -2px -2px 4px rgba(255, 255, 255, 0.6);
            }
        </style>
    @endpush
    <div class="min-h-screen flex items-center justify-center p-4 login-container">
        <div class="w-full max-w-md p-8 login-card">
            <h1 class="text-xl font-semibold mb-6 text-center">Reset Password</h1>

            @if ($errors->any())
                <div class="mb-4 p-4 error-alert border-l-4 border-red-400 text-red-600 rounded-lg text-sm">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('password.update') }}" class="space-y-5">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <input type="hidden" name="email" value="{{ $email }}">

                <div class="space-y-2">
                    <label for="password" class="block text-sm font-medium text-gray-600">Password Baru</label>
                    <div class="relative">
                        <input id="password" type="password" name="password" required
                            class="pl-10 w-full px-4 py-3 rounded-xl input-focus transition-all placeholder-gray-400 text-gray-700"
                            placeholder="••••••••">
                        <button type="button" id="togglePassword"
                            class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5 text-gray-400 hover:text-blue-500 cursor-pointer transition-colors"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>
                    <p class="mt-1 text-xs text-gray-500">
                        Minimal 8 karakter, gunakan huruf besar & kecil, angka, dan simbol.
                    </p>

                </div>

                <div class="space-y-2">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-600">
                        Konfirmasi Password
                    </label>
                    <div class="relative">
                        <input id="password_confirmation" type="password" name="password_confirmation" required
                            class="pl-10 w-full px-4 py-3 rounded-xl input-focus transition-all placeholder-gray-400 text-gray-700"
                            placeholder="••••••••">
                        <button type="button" id="togglePasswordConfirm"
                            class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5 text-gray-400 hover:text-blue-500 cursor-pointer transition-colors"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>
                </div>

                <button type="submit"
                    class="w-full btn-primary py-2.5 px-4 rounded-xl transition-all duration-200 flex items-center justify-center">
                    Simpan Password Baru
                </button>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            function togglePassword(inputId, toggleBtnId) {
                const input = document.getElementById(inputId);
                const button = document.getElementById(toggleBtnId);
                const icon = button.querySelector('svg');

                button.addEventListener('click', () => {
                    if (input.type === 'password') {
                        input.type = 'text';
                        icon.classList.add('text-blue-500');
                    } else {
                        input.type = 'password';
                        icon.classList.remove('text-blue-500');
                    }
                });
            }

            togglePassword('password', 'togglePassword');
            togglePassword('password_confirmation', 'togglePasswordConfirm');
        </script>
    @endpush
</x-app-layout>
