<!DOCTYPE html>
<html>

<head>
    <title>Lupa Password - SmartID</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>

<body class="bg-gray-50 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md bg-white rounded-xl shadow-lg overflow-hidden p-8">
        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-key text-indigo-600 text-2xl"></i>
            </div>
            <h2 class="text-3xl font-bold text-gray-800">Lupa Password</h2>
            <p class="text-gray-600 mt-2">Masukkan email untuk reset password</p>
        </div>

        <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
            @csrf

            <div class="space-y-1">
                <label class="block text-sm font-medium text-gray-700">Email</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-envelope text-gray-400"></i>
                    </div>
                    <input type="email" name="email" required
                        class="pl-10 w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all"
                        placeholder="email@example.com">
                </div>
            </div>

            <button type="submit"
                class="w-full bg-gradient-to-r from-indigo-600 to-indigo-500 hover:from-indigo-700 hover:to-indigo-600 text-white py-3 px-4 rounded-lg font-medium shadow-md hover:shadow-lg transition-all duration-200 transform hover:-translate-y-0.5">
                <i class="fas fa-paper-plane mr-2"></i> Kirim Link Reset
            </button>
        </form>

        @if (session('status'))
            <div class="mt-4 p-3 bg-green-50 text-green-600 rounded-lg flex items-start">
                <i class="fas fa-check-circle mt-1 mr-2"></i>
                <span>{{ session('status') }}</span>
            </div>
        @endif

        @error('email')
            <div class="mt-4 p-3 bg-red-50 text-red-600 rounded-lg flex items-start">
                <i class="fas fa-exclamation-circle mt-1 mr-2"></i>
                <span>{{ $message }}</span>
            </div>
        @enderror

        <div class="mt-6 text-center text-sm text-gray-500">
            <p><a href="{{ route('login') }}" class="text-indigo-600">Kembali ke Login</a></p>
        </div>
    </div>
</body>

</html>