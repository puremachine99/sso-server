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
            <h1 class="text-xl font-semibold mb-6 text-center">Lupa Password</h1>

            @if (session('status'))
                <div class="mb-4 p-4 bg-green-50 border-l-4 border-green-400 text-green-700 rounded-lg text-sm">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
                @csrf
                <div class="space-y-2">
                    <label for="email" class="block text-sm font-medium text-gray-600">Email</label>
                    <div class="relative">
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required
                            autofocus
                            class="pl-10 w-full px-4 py-3 rounded-xl input-focus transition-all placeholder-gray-400 text-gray-700"
                            placeholder="your@email.com">
                    </div>
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit"
                    class="w-full btn-primary py-2.5 px-4 rounded-xl transition-all duration-200 flex items-center justify-center">
                    Kirim Link Reset Password
                </button>
            </form>
        </div>
    </div>
</x-app-layout>
