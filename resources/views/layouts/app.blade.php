<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['JetBrains Mono', 'Fira Code', 'Source Code Pro', 'monospace'],
                    },
                    colors: {
                        primary: {
                            50: '#f0f5ff',
                            100: '#e0eaff',
                            500: '#4a6bff',
                            600: '#2541b2',
                        }
                    }
                }
            }
        }
    </script>

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <!-- Alpine.js -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <style>
        /* Hide scrollbar but keep functionality */
        body::-webkit-scrollbar {
            display: none;
        }

        body {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        /* Smooth transitions for all interactive elements */
        button,
        input,
        a {
            transition: all 0.2s ease;
        }

        
    </style>

    @stack('styles')
</head>

<body class="font-sans antialiased bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen">
    <!-- Main Content -->
    <main class="min-h-screen flex items-center justify-center">
        <div class="w-full max-w-12xl">
            {{ $slot }}
        </div>
    </main>

    @stack('scripts')
</body>

</html>
