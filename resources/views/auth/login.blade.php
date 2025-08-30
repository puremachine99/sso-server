<x-app-layout>
    <div class="min-h-screen flex flex-col lg:flex-row">
        <!-- Left Side (Form) -->
        <div class="relative flex-1 flex items-center justify-center bg-white lg:bg-transparent z-10">
            <!-- Overlay for mobile (gambar di belakang) -->
            <div class="absolute inset-0 lg:hidden">
                <img src="{{ imgproxy('images/bg-login.gif') }}" class="h-full w-full object-cover" />
                <div class="absolute inset-0 bg-black/50"></div>
            </div>

            <!-- Form -->
            <div class="relative w-full max-w-lg p-8 bg-white/90 lg:bg-white rounded-lg shadow-lg lg:shadow-none">
                <!-- Logo -->
                <div class="text-center mb-6">
                    <img src="{{ imgproxy('images/logo.png') }}" alt="Logo" class="h-16 mx-auto">
                </div>

                <!-- Title -->
                <div class="text-center mb-6">
                    <h1 class="text-3xl font-bold text-gray-900">Welcome back!</h1>
                    <p class="text-sm text-gray-500">Sign in dan Lanjut kerja</p>
                </div>

                <!-- Form -->
                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}"
                            class="mt-1 w-full border-b-2 border-gray-300 focus:border-yellow-400 focus:ring-0 px-0 py-2 text-gray-900 placeholder-gray-400 sm:text-sm"
                            placeholder="you@example.com" required autofocus>
                        @error('email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                        <div class="relative">
                            <input type="password" name="password" id="password"
                                class="mt-1 w-full border-b-2 border-gray-300 focus:border-yellow-400 focus:ring-0 px-0 py-2 text-gray-900 placeholder-gray-400 sm:text-sm"
                                placeholder="••••••••" required>
                            <button type="button" id="togglePassword"
                                class="absolute inset-y-0 right-0 flex items-center px-2 text-gray-400 hover:text-gray-600">
                                <i class="far fa-eye"></i>
                            </button>
                        </div>
                        @error('password')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Forgot password -->
                    <div class="flex justify-end">
                        <a href="{{ route('password.request') }}"
                            class="text-sm text-blue-600 hover:text-blue-800">Forgot password?</a>
                    </div>

                    <!-- Submit -->
                    <button type="submit"
                        class="w-full bg-yellow-400 text-navy-900 font-bold py-3 rounded-md shadow hover:bg-yellow-300 transition">
                        <i class="fas fa-sign-in-alt mr-2"></i> Sign In
                    </button>
                </form>
            </div>
        </div>

        <!-- Right Side (Graphics for desktop only) -->
        <div class="hidden lg:flex flex-1 relative">
            <img src="{{ imgproxy('images/bg-login.gif') }}" 
                 class="absolute inset-0 h-full w-full object-cover" />
            <div class="absolute inset-0 bg-black/50"></div>

            <div class="relative z-10 flex flex-col items-center justify-center w-full text-center text-white p-8">
                <h2 class="text-5xl font-bold mb-4">Single Sign On</h2>
                <p class="text-lg max-w-lg">Login sekali buat semua Aplikasi Internal Smart Id.</p>
            </div>
        </div>
    </div>

    <script>
        const togglePassword = document.getElementById('togglePassword');
        const password = document.getElementById('password');

        togglePassword.addEventListener('click', function() {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);

            this.innerHTML = type === 'password' 
                ? '<i class="far fa-eye"></i>' 
                : '<i class="far fa-eye-slash"></i>';
        });
    </script>
</x-app-layout>
