<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Error')</title>

    <link rel="preconnect" href="https://rsms.me/">
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter','system-ui','sans-serif'] },
                    colors: {
                        dark: {
                            bg: 'oklch(21% 0.034 264.665)',
                            text: {
                                primary: '#fff',
                                secondary: 'oklch(70.7% 0.022 261.325)',
                                accent: 'oklch(67.3% 0.182 276.935)',
                            },
                        },
                    },
                },
            },
        }
    </script>
    <style>
        body{
            font-family:'Inter',system-ui,sans-serif;
            -webkit-font-smoothing:antialiased;
            -moz-osx-font-smoothing:grayscale;
            background-color:oklch(21% 0.034 264.665);
            min-height:100vh;
            margin:0;
            display:flex;
            align-items:center;
        }
        .container-custom{max-width:80rem;margin:0 auto;width:100%}
    </style>
    @stack('head')
</head>
<body>
    <main class="container-custom px-6 lg:px-8 py-24">
        <div class="max-w-3xl">
            <p class="text-base font-semibold text-indigo-400">
                @yield('code','Error')
            </p>

            <h1 class="mt-4 text-3xl font-bold tracking-tight text-white sm:text-5xl">
                @hasSection('heading')
                    @yield('heading')
                @elseif (trim($__env->yieldContent('message')))
                    @yield('message')
                @else
                    Something went wrong
                @endif
            </h1>

            <p class="mt-6 text-lg leading-7 text-gray-400">
                @yield('description','Sorry, an unexpected error occurred.')
            </p>

            <div class="mt-10">
                @hasSection('actions')
                    @yield('actions')
                @else
                    <a href="{{ url('/') }}" class="text-sm font-semibold text-indigo-400 hover:text-white">
                        <span aria-hidden="true">&larr;</span> Back to home
                    </a>
                @endif
            </div>

            @yield('extra')
        </div>
    </main>

    @stack('body')
</body>
</html>
