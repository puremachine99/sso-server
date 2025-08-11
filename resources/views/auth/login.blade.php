<x-app-layout>
    @push('styles')
        <style>
            .login-container {
                background-color: #f0f2f5;
                background-image: 
                    radial-gradient(at 10% 20%, rgba(255,255,255,0.8) 0, transparent 50%),
                    radial-gradient(at 90% 80%, rgba(255,255,255,0.8) 0, transparent 50%);
            }
            
            .login-card {
                background: #f0f2f5;
                border-radius: 24px;
                box-shadow: 
                    8px 8px 16px rgba(163, 177, 198, 0.6),
                    -8px -8px 16px rgba(255, 255, 255, 0.7);
                border: 1px solid rgba(255,255,255,0.2);
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
                border: 1px solid rgba(0,0,0,0.05);
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
        <div class="w-full max-w-md p-8 login-card transform transition-all duration-300 hover:scale-[1.01]">
            <div class="text-center mb-8">
                <div class="mx-auto mb-4 w-20 h-20 rounded-2xl flex items-center justify-center bg-gradient-to-br from-blue-50 to-white shadow-neumorph">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3m-2.118 6.844A21.88 21.88 0 0015.171 17m3.839 1.132c.645-2.266.99-4.659.99-7.132A8 8 0 008 4.07M3 15.364c.64-1.319 1-2.8 1-4.364 0-1.457.39-2.823 1.07-4" />
                    </svg>
                </div>
                <h2 class="text-2xl font-semibold text-gray-800">Welcome Back</h2>
                <p class="text-gray-500 mt-1 text-sm">Sign in to your SmartID account</p>
            </div>

            <form method="POST" action="/login" class="space-y-5">
                @csrf

                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-600">Email Address</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <input type="email" name="email" required
                            class="pl-10 w-full px-4 py-3 rounded-xl input-focus transition-all placeholder-gray-400 text-gray-700"
                            placeholder="your@email.com">
                    </div>
                </div>

                <div class="space-y-2">
                    <div class="flex justify-between items-center">
                        <label class="block text-sm font-medium text-gray-600">Password</label>
                        <a href="{{ route('password.request') }}" class="text-xs forgot-link">Forgot password?</a>
                    </div>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <input type="password" name="password" id="password" required
                            class="pl-10 w-full px-4 py-3 rounded-xl input-focus transition-all placeholder-gray-400 text-gray-700"
                            placeholder="••••••••">
                        <button type="button" id="togglePassword"
                            class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 hover:text-blue-500 cursor-pointer transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="flex items-center">
                    <input id="remember-me" name="remember-me" type="checkbox" class="h-4 w-4 text-blue-500 focus:ring-blue-400 border-gray-300 rounded checkbox">
                    <label for="remember-me" class="ml-2 block text-sm text-gray-600">
                        Remember me
                    </label>
                </div>

                <button type="submit"
                    class="w-full btn-primary py-2.5 px-4 rounded-xl transition-all duration-200 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                    </svg>
                    Sign In
                </button>
            </form>

            @error('email')
                <div class="mt-4 p-4 error-alert border-l-4 border-red-400 text-red-600 rounded-lg flex items-start">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mt-0.5 mr-3 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <span class="text-sm">{{ $message }}</span>
                </div>
            @enderror

            <div class="mt-6 pt-5 border-t border-gray-200 text-center text-sm text-gray-500">
                <a href="#" class="forgot-link font-medium">Need help signing in?</a>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.getElementById('togglePassword').addEventListener('click', function() {
                const passwordInput = document.getElementById('password');
                const icon = this.querySelector('svg');

                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />';
                    icon.classList.add('text-blue-500');
                } else {
                    passwordInput.type = 'password';
                    icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />';
                    icon.classList.remove('text-blue-500');
                }
            });
        </script>
    @endpush
</x-app-layout>