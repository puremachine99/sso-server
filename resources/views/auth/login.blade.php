<x-app-layout>
    @push('styles')
        <style>
            .login-container {
                background-image: none !important;
                background: linear-gradient(135deg, #0f172a 0%, #1e40af 100%);
            }
            
            .login-card {
                backdrop-filter: blur(10px);
                background: rgba(255, 255, 255, 0.95);
                border-radius: 1.5rem;
                box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 
                            0 10px 10px -5px rgba(0, 0, 0, 0.04);
            }
            
            .btn-primary {
                background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
                box-shadow: 0 4px 6px -1px rgba(30, 64, 175, 0.3), 
                            0 2px 4px -1px rgba(30, 64, 175, 0.2);
            }
            
            .btn-primary:hover {
                background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%);
                transform: translateY(-2px);
            }
            
            .input-focus:focus {
                border-color: #3b82f6;
                box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
            }
        </style>
    @endpush

    <div class="min-h-screen flex items-center justify-center p-4 login-container">
        <div class="w-full max-w-md p-8 login-card transform transition-all duration-300 hover:scale-[1.01]">
            <div class="text-center mb-8">
                <img src="{{asset('images/logo.png')}}" alt="" class="mx-auto mb-4 w-24">
                <h2 class="text-3xl font-bold text-gray-800">Welcome Back</h2>
                <p class="text-gray-600 mt-2">Sign in to your SmartID account</p>
            </div>

            <form method="POST" action="/login" class="space-y-6">
                @csrf

                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">Email Address</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-envelope text-gray-400"></i>
                        </div>
                        <input type="email" name="email" required
                            class="pl-10 w-full px-4 py-3 rounded-lg border border-gray-300 input-focus transition-all placeholder-gray-400"
                            placeholder="your@email.com">
                    </div>
                </div>

                <div class="space-y-2">
                    <div class="flex justify-between items-center">
                        <label class="block text-sm font-medium text-gray-700">Password</label>
                        <a href="{{ route('password.request') }}" class="text-xs text-blue-600 hover:text-blue-800">Forgot password?</a>
                    </div>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-gray-400"></i>
                        </div>
                        <input type="password" name="password" id="password" required
                            class="pl-10 w-full px-4 py-3 rounded-lg border border-gray-300 input-focus transition-all placeholder-gray-400"
                            placeholder="••••••••">
                        <button type="button" id="togglePassword"
                            class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <i class="fas fa-eye text-gray-400 hover:text-yellow-500 cursor-pointer transition-colors"></i>
                        </button>
                    </div>
                </div>

                <div class="flex items-center">
                    <input id="remember-me" name="remember-me" type="checkbox" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <label for="remember-me" class="ml-2 block text-sm text-gray-700">
                        Remember me
                    </label>
                </div>

                <button type="submit"
                    class="w-full btn-primary text-white py-3 px-4 rounded-lg font-semibold shadow-lg transition-all duration-200 flex items-center justify-center">
                    <i class="fas fa-sign-in-alt mr-2"></i> Sign In
                </button>
            </form>

            @error('email')
                <div class="mt-4 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-lg flex items-start">
                    <i class="fas fa-exclamation-triangle mt-1 mr-3 text-red-500"></i>
                    <span class="text-sm">{{ $message }}</span>
                </div>
            @enderror

            <div class="mt-8 pt-6 border-t border-gray-200 text-center text-sm text-gray-600">
                <a href="#" class="text-blue-600 font-medium hover:text-blue-800">Forgot Password</a>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.getElementById('togglePassword').addEventListener('click', function() {
                const passwordInput = document.getElementById('password');
                const icon = this.querySelector('i');

                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    icon.classList.replace('fa-eye', 'fa-eye-slash');
                    icon.classList.add('text-yellow-500');
                } else {
                    passwordInput.type = 'password';
                    icon.classList.replace('fa-eye-slash', 'fa-eye');
                    icon.classList.remove('text-yellow-500');
                }
            });
        </script>
    @endpush
</x-app-layout>